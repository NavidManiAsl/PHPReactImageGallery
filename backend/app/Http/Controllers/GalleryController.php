<?php

namespace App\Http\Controllers;

use App\Actions\{AddImageAction, RemoveImageAction};
use App\Exceptions\BadRequestException;
use App\Http\Requests\{AddRemoveImageRequest, StoreGalleryRequest};
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Log;
use App\Exceptions\DuplicateImagesException;

class GalleryController extends Controller
{
    use HttpResponse;


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {

        if (!$request->user('sanctum')) {
            return $this->unauthenticated();
        }
        $gallery = Gallery::create([
            "name" => $request->name,
            "tags" => $request->tags,
            "user_id" => $request->user('sanctum')->id,
        ]);

        try {
            $gallery->save();
            return $this->success($gallery, 'Gallery has been created successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->serverError();
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $user = $request->user('sanctum');
        if (!$user) {
            return $this->unauthenticated();
        }

        try {
            $galleries = Gallery::where('user_id', $user->id)->get();
            return $this->success($galleries, 'ok', 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->serverError();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {

        try {
            return $this->success($gallery, 'ok', 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->error(null, 'not Found', 404);
        }
    }

    /**
     * Add image to an existing gallery
     */
    public function addImage(AddRemoveImageRequest $request, AddImageAction $action)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return $this->unauthenticated();
        }

        try {
            $action($request);
            return $this->success(null, 'Image has been added to gallery', 200);
        } catch (DuplicateImagesException) {
            return $this->success(null, 'Image has been added, Duplication has been ignored', 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->serverError();
        }

    }

    /**
     * Remove images from an existing gallery 
     */
    public function removeImage(AddRemoveImageRequest $request, RemoveImageAction $action)
    {
        
       try {
        $action($request);
        return $this->success(null, 'Image has been successfully deleted', 200);
       } catch (BadRequestException $e) {
        return $this->error(null, 'Bad Request', 400);
       } catch (\Throwable $th) {
        Log::error($th->getMessage());
        return $this->serverError();
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        if(!$gallery){
            return $this->error(null, 'Not found',404);
        }
        try {
            Gallery::destroy($gallery->id);

            return $this->success(null,'Deleted', 204);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->serverError();
        }
    }
}
