<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class MediaController extends Controller
{
    public function store(Request $r)
    {
        $r->validate([
            'file'   => ['required', File::image()->max(5 * 1024)],
            'folder' => ['nullable','string','max:64'],
        ]);

        $disk   = config('filesystems.default', 'public');
        $folder = trim($r->input('folder', 'uploads'), '/');
        $path   = $r->file('file')->store($folder.'/'.date('Y/m'), $disk);

        return response()->json([
            'success' => true,
            'data' => [
                'path' => $path,
                'url'  => $this->publicUrl($disk, $path),
            ],
        ], 201);
    }

    public function destroy(Request $r)
    {
        $r->validate([
            'path' => ['required','string','max:255'],
        ]);

        $disk = config('filesystems.default', 'public');
        $ok   = Storage::disk($disk)->delete($r->input('path'));

        return response()->json(['success' => $ok]);
    }

    private function publicUrl(string $disk, string $path): string
    {
        if ($disk === 's3') {
            return Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(10));
        }
        return Storage::disk($disk)->url($path);
    }
}
