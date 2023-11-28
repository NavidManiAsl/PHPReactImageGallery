<?php

namespace App\Http\Controllers;

use App\Actions\AddTagsAction;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Actions\StoreImageAction;
use App\Http\Requests\AddRemoveTagsRequest;
use App\Http\Requests\StoreImageRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        
        try {
            $images = Image::where("user_id", auth('sanctum')->id())->get();
            return $this->success($images);
        } catch (\Throwable $th) {
            Log::error($th->getMessage().$th->getTrace());
            return  $this->serverError();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request, StoreImageAction $storeImageAction)
    {
       
        if ($storeImageAction($request)) {
           return  $this->success(null, 'Image has been successfully uploaded');
        } else {
           
            return  $this->serverError();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        try {
            
            return $this->success($image);
        } catch (\Throwable $th) {
            Log::error($th->getMessage().$th->getTrace());
            return  $this->serverError();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        try {
            $image::destroy($image->id);
            return $this->success(null,'Deleted',204);
        } catch (\Throwable $th) {
            Log::error($th->getMessage().$th->getTrace());
            return  $this->serverError();
        }
        
    }

    /**
     * Add tags to an image.
     */
    public function addTags(AddRemoveTagsRequest $request, AddTagsAction $action)
    {
        if(!$action($request)){
            return $this->serverError();
        };
        return $this->success(null,'Tags has been successfully updated',200);
    }
}
