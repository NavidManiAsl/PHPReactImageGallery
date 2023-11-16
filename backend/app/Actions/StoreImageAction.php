<?php
namespace App\Actions;

use App\Http\Requests\StoreImageRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image as InterventionImage;

class StoreImageAction
{

    public function __invoke(StoreImageRequest $request)
    {
        $image = new Image();
        $file = $request->file("image");
        $thumb = InterventionImage::make($file)
            ->resize(125, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(storage_path('storage') . $file->getClientOriginalName());
        $hashedName = $file->store();
        $fileDimension = $file->dimensions()[0] . ' x ' . $file->dimensions()[1];

        $image->name = $file->getClientOriginalName();
        $image->path = storage_path() . '/' . $hashedName;
        $image->thumbnail_path = $thumb->basePath();
        $image->description = $request->get('description');
        $image->size = $file->getSize();
        $image->dimension = $fileDimension;
        $image->tags = $request->get('tags');
        $image->user_id = Auth::guard('sanctum')->user()->id;
        $image->gallery_id = $request->gallery ?
            $request->gallery
            : 1;

        try {
            $image->save();
            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
        ;

    }

}
;