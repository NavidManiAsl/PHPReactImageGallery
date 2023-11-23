<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGalleryRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Log;

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
            "name"=> $request->name,
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
    public function index(Request $request){
        
        $user = $request->user('sanctum');
        if(!$user) {
            return $this->unauthenticated();
        }

        try {
            $galleries = Gallery::where('user_id', $user->id)->get();
            return $this->success($galleries,'ok',200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->serverError();
        }
    }
}
