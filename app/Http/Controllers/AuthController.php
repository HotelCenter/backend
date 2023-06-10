<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'authenticated']]);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);

        }
        $credentials = $request->only('email', 'password');
        $token = auth()->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
        // $user=Auth::user();
        return $this->respondWithToken($token);
    }
    public function register(Request $request)
    {
        $validator = validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|string|email',
            'password' => 'required|string',
            'address' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'code_postal' => 'required|integer',
            'phone_number' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);

        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'code_postal' => $request->code_postal,
        ]);
        // echo $request->code_postal;
        $token = auth()->login($user);
        return $this->respondWithToken($token);

    }
    public function me()
    {
        return response()->json(auth()->user());

    }
    public function authenticated()
    {
        return response()->json([
            "authenticated" => auth()->check()
        ]);

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
            'expires_in' => auth()->factory()->getTTL() * 3600 * 24 * 7,
        ]);
    }
}