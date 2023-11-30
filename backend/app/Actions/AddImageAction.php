<?php
namespace App\Actions;

use App\Http\Requests\AddRemoveImageRequest;
use App\Models\Gallery;
use App\Exceptions\DuplicateImagesException;

class AddImageAction
{
    public function __invoke(AddRemoveImageRequest $request)
    {
        $galleryId = $request->gallery;
        $gallery = Gallery::where('id', $galleryId)->first();

        $currentImages = $gallery->images ? $gallery->images : [];
        $newImages = json_decode(request()->images);

        if (array_intersect($currentImages, $newImages)) {
            throw new DuplicateImagesException;
        }
        $galleryImages = array_unique(array_merge($currentImages, $newImages));
        $gallery->images = $galleryImages;

        $gallery->save();

    }
}