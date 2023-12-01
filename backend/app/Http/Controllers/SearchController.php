<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    use HttpResponse;
    public function search(SearchRequest $request, ImageController $imageController, GalleryController $galleryController)
    {
        $user = $request->user('sanctum')->id;
        $query = htmlspecialchars($request->input("query"));

        try {
            $images = $imageController->search($query, $user);
            $galleries = $galleryController->search($query, $user);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->serverError();
        }
        if(empty($images) && empty($galleries)) {
            return $this->error(null, 'Not Found', 404);
        }

        $searchResult = ['images' => $images, 'galleries' => $galleries];

        return $this->success($searchResult);

    }
}
