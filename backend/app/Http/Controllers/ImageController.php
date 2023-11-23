<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Actions\StoreImageAction;
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
       
        if(!$request->user('sanctum')){
            return $this->unauthenticated();
        }
        try {
            $images = Image::where("user_id", auth('sanctum')->id())->get();
            return $this->success($images);
        } catch (\Throwable $th) {
            Log::error($th->getMessage().$th->getTrace());
            return  $this->error(null, 'Unexpected error', '500');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request, StoreImageAction $storeImageAction)
    {
       if(!$request->user('sanctum')){
        return $this->unauthenticated();
       }
        if ($storeImageAction($request)) {
           return  $this->success(null, 'Image has been successfully uploaded');
        } else {
           
            return  $this->error(null, 'Unexpected error', '500');
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
            return  $this->error(null, 'Unexpected error', '500');
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
            return  $this->error(null, 'Unexpected error', '500');
        }
        
    }
}
