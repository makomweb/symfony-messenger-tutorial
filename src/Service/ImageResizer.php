<?php

namespace App\Service;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class ImageResizer
{
    private const MAX_WIDTH = 200;
    private const MAX_HEIGHT = 150;

    private $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    public function resize(string $filename): void
    {
        list($iwidth, $iheight) = getimagesize($filename);
        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH;
        $height = self::MAX_HEIGHT;
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }

        $photo = $this->imagine->open($filename);

        $thumbnail = $this->thumbNailPath($filename);

        $photo->resize(new Box($width, $height))->save($thumbnail);
    }

    private function thumbNailPath(string $filename): string
    {
        $path_parts = pathinfo($filename);

        return $path_parts['dirname'] . '/' . $path_parts['filename'] . '.thumbnail.' . $path_parts['extension'];
    }
}
