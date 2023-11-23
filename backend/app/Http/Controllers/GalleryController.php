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
            return $this->error(null,'Unexpected Error', 500);
        }
    }
}
