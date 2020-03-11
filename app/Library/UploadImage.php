<?php

namespace App\Library;

use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Storage;

class UploadImage {
    /**
     * @param $image
     * @return string
     */
    static public function upload($image, $path, $weight = 60 )
    {
        $img = Image::make($image);
        $img->resize($weight, null, function ($c) {
            $c->aspectRatio();
        });

        $imageName = time() . str_random(27) . '.jpg';
        Storage::disk($path)->put($imageName, $img->encode('jpg', 100));

        return $imageName;
    }

    /**
     * @param $id
     * @param $path
     * @param $class
     */
    static function delete($id, $path, $class)
    {
        $img = $class::select('icon')->where('id', $id)->first();

        if ($img != null) {
            Storage::disk($path)->delete($img->icon);
        }
    }
}