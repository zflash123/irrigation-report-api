<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 400);
        }

        $user = auth()->user();
        $customClaims = ['user' => $user->toArray()];
        $jwt = JWTAuth::claims($customClaims)->attempt($credentials);

        return $this->respondWithToken($token, $jwt);
    }

    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'urole_id' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'fullname' => 'required',
            'shortname' => 'required',
            'avatar' => 'required',
            'phone' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $user = User::create([
            'urole_id' => request('urole_id'),
            'username' => request('username'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'fullname' => request('fullname'),
            'shortname' => request('shortname'),
            'avatar' => request('avatar'),
            'phone' => request('phone'),
            'status' => request('status'),
            'created_at' => Carbon::now(),
        ]);

        if ($user) {
            return response()->json(['message' => 'Pendaftaran Berhasil']);
        } else {
            return response()->json(['message' => 'Pendaftaran Gagal']);
        };
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token, $jwt)
    {
        return response()->json([
            'data' => [
                'token' => $token,
                'jwtToken' => $jwt,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ],
            'statusCode' => 200,
            'message' => 'OK'
        ]);
    }
}
