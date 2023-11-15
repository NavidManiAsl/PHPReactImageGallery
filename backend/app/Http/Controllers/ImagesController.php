<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Actions\StoreImageAction;
use App\Http\Requests\StoreImageRequest;

class ImagesController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request, StoreImageAction $storeImageAction)
    {
       
        if ($storeImageAction($request)) {
           return  $this->success(null, 'Image has been successfully uploaded');
        } else {
           return  $this->error(null, 'Unexpected error', '500');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
