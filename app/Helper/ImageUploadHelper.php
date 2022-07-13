<?php


namespace App\Helper;

use Image;

class ImageUploadHelper
{
    public static function saveImage($image, $fileNameUpload, $path)
    {
        $publicPath =  public_path($path);
        Image::make($image)->save($publicPath . $fileNameUpload);

        return $path . $fileNameUpload;
    }
}
