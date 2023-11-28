<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponse;
    public function login(LoginUserRequest $request)
    {
        if (!Auth::attempt($request->only("email", "password"))) {
            return $this->error(null, 'User and or password does not match', 401);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('accesstoken ' . $user->name)->plainTextToken;
        return $this->success([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function register(RegisterUserRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('accesstoken ' . $user->name)->plainTextToken;

        return $this->success([
            'user' => $user,
            'token' => $token
        ]);

    }

    public function logout(Request $request)
    {
       

        $request->user()->tokens()->delete();
        return $this->success(null, null, $code = 204);
    }
}
