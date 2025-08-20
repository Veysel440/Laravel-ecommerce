<?php

namespace App\Services\Media;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageProcessor
{
    private ImageManager $im;

    public function __construct()
    {
        $this->im = new ImageManager(new Driver());
    }

    /**
     * @return array{binary:string,mime:string,width:int,height:int}
     */
    public function reencode(string $binary): array
    {
        $img = $this->im->read($binary);

        $maxW = (int) config('media.max_width');
        $maxH = (int) config('media.max_height');
        if ($img->width() > $maxW || $img->height() > $maxH) {
            $img->scaleDown($maxW, $maxH);
        }

        $mime = $img->mime();
        $q = (int) config('media.jpeg_quality', 82);

        if ($mime === 'image/png') {
            $out = $img->toPng()->toString();
            $mimeOut = 'image/png';
        } elseif ($mime === 'image/webp') {
            $out = $img->toWebp(85)->toString();
            $mimeOut = 'image/webp';
        } else {
            $out = $img->toJpeg($q)->toString();
            $mimeOut = 'image/jpeg';
        }

        return ['binary'=>$out,'mime'=>$mimeOut,'width'=>$img->width(),'height'=>$img->height()];
    }

    /**
     *
     * @return array<string,string> key => binary
     */
    public function variants(string $binary): array
    {
        $img = $this->im->read($binary);
        $q = (int) config('media.jpeg_quality', 82);

        $out = [];
        foreach (config('media.variants') as $key => [$w,$h]) {
            $clone = $img->clone()->cover($w, $h);
            $out[$key] = $clone->toJpeg($q)->toString();
        }
        return $out;
    }
}
