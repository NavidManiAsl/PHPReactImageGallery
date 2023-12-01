<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    use HttpResponse;
    private $imageController;
    private $galleryController;
    public function __construct(ImageController $imageController, GalleryController $galleryController){
        $this->imageController = $imageController;
        $this->galleryController = $galleryController;
    }
    
    public function search(SearchRequest $request )
    {
        $user = $request->user('sanctum')->id;
        $query = htmlspecialchars($request->input("query"));

        try {
            $images = $this->imageController->search($query, $user);
            $galleries = $this->galleryController->search($query, $user);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->serverError();
        }
        if(empty($images) && empty($galleries)) {
            return $this->error(null, 'Not Found', 204);
        }

        $searchResult = ['images' => $images, 'galleries' => $galleries];

        return $this->success($searchResult);

    }
}
