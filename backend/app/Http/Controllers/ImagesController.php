<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Actions\StoreImageAction;


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
    public function store(Request $request, StoreImageAction $storeImageAction)
    {
        if (auth('sanctum')->check()) {
            $user = auth('sanctum')->user();
            
        } else {
            $this->error(null, 'Unauthorized', 401);
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
