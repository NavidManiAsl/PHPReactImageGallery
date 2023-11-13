<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponse;
    public function login()
    {
        return $this->success('login');
    }

    public function register(RegisterUserRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('accesstoken' . $user->name)->plainTextToken;

        return $this->success([
            'user' => $user,
            'token' => $token
        ]);

    }

    public function logout()
    {
        return $this->success('logout');
    }
}
