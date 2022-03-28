<?php


namespace App\Helper;

use Image;

class ImageUploadHelper
{
    public static function saveImage($image, $fileNameUpload, $path)
    {

        Image::make($image)->save($path . $fileNameUpload);

        return $path . $fileNameUpload;
    }
}
