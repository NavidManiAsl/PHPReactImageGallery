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
        $children = unserialize($gallery->images);
    
        $currentImages = $children ? $children : [];
        $newImages = unserialize(request()->images);
        
        if(array_intersect($currentImages, $newImages)) {
            throw new DuplicateImagesException;
        }
        $galleryImages = array_unique(array_merge($currentImages, $newImages));
        $gallery->images = serialize($galleryImages);

       $gallery->save();

    }
}