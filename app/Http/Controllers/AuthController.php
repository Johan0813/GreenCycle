<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\User;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

use App\Http\Resources\UserResource;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
public function register(RegisterRequest $request)
{
    $user = User::create([
        'name' => $request->validated('name'),
        'email' => $request->validated('email'),
        'password' => Hash::make($request->validated('password')),
        'coins' => 0,
    ]);

    $token = $user->createToken('api')->plainTextToken;

    return (new UserResource($user))
        ->additional(['token' => $token])
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);
}


public function login (LoginRequest $request){

    $user = $request->authenticate();

    $token = $user->createToken('api')->plainTextToken;

    return (new UserResource($user))
    ->additional(['token' => $token])
    ->response()
    ->setStatusCode(Response::HTTP_OK);
}

public function me (Request $request){

    return new UserResource($request->user());
}

public function logout (Request $request){
    $request->user()->currentAccessToken()->delete();

    return response() -> json ([
        'message' => 'Sesion cerrada con exito.',
    ],Response::HTTP_OK);
}

}
