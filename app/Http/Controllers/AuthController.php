<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|string'
        ]);
        $credentials=$request->only('email','password');
        $token=auth()->attempt($credentials);
        if(!$token){
            return response()->json([
                'status'=>'error',
                'message'=>'Unauthorized'
            ],401);
        }
        // $user=Auth::user();
        return $this->respondWithToken($token);
    }
    public function register(Request $request){
        $request->validate([
            'name'=>'required|string|max:100',
            'email'=>'required|string|email',
            'password'=>'required|string'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $token=auth()->login($user);
        return $this->respondWithToken($token);

    }
    public function me(){
        return response()->json(auth()->user());

    }
    public function logout()
    {
        auth()->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
