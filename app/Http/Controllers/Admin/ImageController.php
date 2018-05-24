<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Image as ImageResource;
use App\Http\Resources\ImageCollection;
use App\Image;
use App\Http\Requests\SaveImage;


class ImageController extends Controller
{
    public function all()
    {
        return new ImageCollection(Image::all());
    }

    public function save(SaveImage $request)
    {
        $record = new Image();
        $path = $request->file->store('public/images');
        $exp = explode('/', $path);
        $path = end($exp);
        $record->filename = $path;
        $record->save();

        return new ImageResource($record);
    }

    public function delete($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();
        return response()->json(['status' => 'success']);
    }
}
