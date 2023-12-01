<?php

namespace App\Http\Controllers;

use App\Actions\{AddImageAction, AddTagsAction, RemoveImageAction, RemoveTagsAction};
use App\Exceptions\BadRequestException;
use App\Http\Requests\{AddRemoveImageRequest, AddRemoveTagsRequest, StoreGalleryRequest};
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
    public function show(Gallery $gallery, Request $request)
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
        if (!$gallery) {
            return $this->error(null, 'Not found', 404);
        }
        try {
            Gallery::destroy($gallery->id);

            return $this->success(null, 'Gallery has been successfully deleted', 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->serverError();
        }
    }

    /**
     * Add tags to a gallery.
     */
    public function addTags(AddRemoveTagsRequest $request, AddTagsAction $action)
    {

        if (!$action($request)) {
            return $this->serverError();
        }
        ;
        return $this->success(null, 'Tags has been successfully added', 200);
    }

    /** 
     * Remove tags from a gallery.
     */
    public function removeTags(AddRemoveTagsRequest $request, RemoveTagsAction $action)
    {

        try {
            $action($request);
            return $this->success(null, 'Tags has been removed successfully', 200);
        } catch (BadRequestException) {
            return $this->error(null, 'Bad request', 400);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->serverError();
        }

    }

    public function search(string $query, int $user)
    {
        try {
            $searchResult = Gallery::whereJsonContains('tags', $query)->where('user_id', $user)->get();
        } catch (\Throwable $th) {
            throw new \Exception;
        }
        return $searchResult;
    }
}
