<?php

namespace App\Actions;

use App\Exceptions\BadRequestException;
use App\Http\Requests\AddRemoveTagsRequest;
use App\Models\Gallery;
use App\Models\Image;

class RemoveTagsAction
{

    public function __invoke(AddRemoveTagsRequest $request)
    {
        if ($request->image) {
            $image = Image::find($request->image);
            $currentTags = $image->tags;
            $tagsToRemove = json_decode($request->get('tags'));

            if (count(array_intersect($tagsToRemove, $currentTags)) !== count($tagsToRemove)) {
                throw new BadRequestException;
            }
            $image->tags = array_values(array_diff($currentTags, $tagsToRemove));

            $image->save();
        } else {
            $gallery = Gallery::find($request->gallery);
            $currentTags = $gallery->tags;
            $tagsToRemove = json_decode($request->get('tags'));

            if (count(array_intersect($tagsToRemove, $currentTags)) !== count($tagsToRemove)) {
                throw new BadRequestException;
            }
            $gallery->tags = array_values(array_diff($currentTags, $tagsToRemove));

            $gallery->save();
        }
    }
}