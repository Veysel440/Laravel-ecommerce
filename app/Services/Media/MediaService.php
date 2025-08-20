<?php

namespace App\Services\Media;


use App\Models\Media;
use App\Support\FileName;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public function __construct(
        private ImageProcessor $img,
        private ClamAvScanner $av
    ) {}

    /** @return array<Media> */
    public function storeMany(array $files, ?int $userId=null): array
    {
        $out = [];
        foreach ($files as $file) {
            $out[] = $this->storeOne($file, $userId);
        }
        return $out;
    }

    public function storeOne(UploadedFile $file, ?int $userId=null): Media
    {
        $disk = config('media.disk');
        $allowed = config('media.allowed_mimes', []);
        $raw = file_get_contents($file->getRealPath());
        if ($raw === false) abort(422, 'file_read_error');

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $sigMime = $finfo->buffer($raw) ?: 'application/octet-stream';
        if (!in_array($sigMime, $allowed, true)) abort(415, 'unsupported_media_type');

        if (!$this->av->scan($raw)) abort(422, 'virus_scan_failed');

        $processed = $this->img->reencode($raw);
        $binary = $processed['binary'];
        $mime   = $processed['mime'];

        $variantsBin = $this->img->variants($binary);

        $checksum = hash('sha256', $binary);
        $ext = match ($mime) {
            'image/png'  => 'png',
            'image/webp' => 'webp',
            default      => 'jpg',
        };
        $dir = 'media/'.substr($checksum,0,2).'/'.substr($checksum,2,2);
        $base = pathinfo(FileName::sanitize($file->getClientOriginalName()), PATHINFO_FILENAME) ?: 'image';
        $name = $base.'-'.substr($checksum,0,8).'.'.$ext;

        $path = $dir.'/'.$name;
        Storage::disk($disk)->put($path, $binary, 'public');

        $variants = [];
        foreach ($variantsBin as $key => $bin) {
            $vname = $base.'-'.substr($checksum,0,8).'-'.$key.'.jpg';
            $vpath = $dir.'/'.$vname;
            Storage::disk($disk)->put($vpath, $bin, 'public');
            $variants[$key] = $vpath;
        }

        return Media::create([
            'user_id' => $userId,
            'disk'    => $disk,
            'path'    => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime'    => $mime,
            'size'    => strlen($binary),
            'width'   => $processed['width'],
            'height'  => $processed['height'],
            'checksum'=> $checksum,
            'variants'=> $variants,
        ]);
    }

    public function delete(Media $m): void
    {
        $disk = Storage::disk($m->disk);
        $disk->delete($m->path);
        foreach ((array) $m->variants as $p) { $disk->delete($p); }
        $m->delete();
    }
}
