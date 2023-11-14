<?php
namespace App\Traits;
trait HttpResponse {

    public function success ($data, $message=null, $code=200){

        return response()->json([
            'status' => 'ok',
            'message' => $message, 
            'data' => $data
        ],$code);
    }

    public function error ($data, $message, $code){

        return response()->json([
            'status' => 'error',
            'message' => $message, 
            'data' => $data
        ],$code);
    }
}