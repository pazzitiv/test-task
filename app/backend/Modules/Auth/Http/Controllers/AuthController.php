<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Modules\User\Transformers\UserResource;

class AuthController extends Controller
{
    public function login(Request $request): array
    {
        $credentials = $request->only('login', 'password');
        Auth::guard()->login($credentials);

        $token = Auth::guard()->getToken() ?? '';

        throw_if($token === '', new UnauthorizedException());

        return [
            'user' => UserResource::make($request->user()),
            'token' => $token
        ];
    }

    public function test()
    {
        $rand = rand(0, 998);

        $result = (int)($rand / 333);

        return $result;
    }
}
