<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class ImageCacheController extends Controller
{
    public function show(Request $request, $h, $w, $filename)
    {

        $originalPath = storage_path('app/public/images/'.$filename);

        // if original image not exists return error
        if(!file_exists($originalPath)){  
            Log::error('image_error');
            return 'error';
        }

        if($h > 1920 || $h < 10 || $w > 1920 || $w < 10) {
            Log::error('image_size_error');
            return 'size_error';
        }

        $cachedImagePath = storage_path("app/public/images/$h-$w-$filename");

        // if cached image exists return image
        if(file_exists($cachedImagePath)){
            Log::info('cached image exists. returning');
            return Image::make($cachedImagePath)->response();
        }

        $newImage = Image::make($originalPath);
        $newImage->fit($w, $h, function($constrait){
            $constrait->upsize();
        });
        $savedImage = $newImage->save($cachedImagePath);
        Log::info('new cache image created');

        return Image::make($savedImage)->response();
    }    

    public function showNormalImage(Request $request, $filename)
    {
        $originalPath = storage_path('app/public/images/'.$filename);
        return Image::make($originalPath)->response();
    }
}
