<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HttpResponse;
    public function login (){
        return $this->success('login');
    }

    public function register (){
        return $this->success('register');
    }

    public function logout (){
        return $this->success('logout');
    }
}
