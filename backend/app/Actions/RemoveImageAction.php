<?php

namespace App\Actions;

use App\Exceptions\BadRequestException;
use App\Http\Requests\AddRemoveImageRequest;
use App\Models\{Image, Gallery};
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Log;

class RemoveImageAction
{
    use HttpResponse;
    public function __invoke(AddRemoveImageRequest $request)
    {
        $galleryId = $request->gallery;
        $gallery = Gallery::findOrFail($galleryId);
        $currentImages = $gallery->images ? $gallery->images : [];
        $requestImages = json_decode($request->input('images'));
        if (count(array_intersect($currentImages, $requestImages)) !== count($requestImages)) {
            throw new BadRequestException();
        }
        $gallery->images = array_values(array_diff($currentImages, $requestImages));
        try {
            $gallery->save();
            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}