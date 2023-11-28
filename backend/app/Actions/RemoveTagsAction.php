<?php

namespace App\Actions;

use App\Exceptions\BadRequestException;
use App\Http\Requests\AddRemoveTagsRequest;
use App\Models\Image;

class RemoveTagsAction{

    public function __invoke(AddRemoveTagsRequest $request)
    {
        $image = Image::find($request->image);
        $currentTags = $image->tags;
        $tagsToRemove = unserialize($request->get('tags'));
        
        if (count(array_intersect($tagsToRemove, $currentTags)) !== count($tagsToRemove)) {
            throw new BadRequestException;
        }
        $image->tags = array_values(array_diff($currentTags, $tagsToRemove));

        $image->save();
    }
}