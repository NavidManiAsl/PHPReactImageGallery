<?php

namespace App\Actions;
use App\Models\Image;

use App\Http\Requests\AddRemoveTagsRequest;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Log;

class AddTagsAction 
{  
    use HttpResponse;
    
    public function __invoke(AddRemoveTagsRequest $request)
    {
        $image =Image::find($request->image);
        $currentTags = $image->tags?$image->tags:[];
        $newTags = unserialize($request->input("tags"));
        $image->tags = array_unique(array_merge($currentTags,$newTags));
      

        try {
            $image->save();
            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return false;
        }
        
        
    }
}