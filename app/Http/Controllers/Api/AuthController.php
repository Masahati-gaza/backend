<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'full_name'=>'required|string',
            'phone'=>'required|numeric',
            'email'=>'required|email|unique:users,email',
            'profile_picture'=>'nullable|image',
            'password'=>'requird',
        ]);
        $request->merge([
            'password'=>bcrypt($request->password)
        ]);
        if($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('/picture', 'public');
            $request->merge([
                'profile_picture_url' => $path
            ]);
        }

        $user = User::create($request->all());

        return response()->json([
            'user'=>$user,
            'status'=>201,
            'message'=>'user registered successfully'
        ]);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);


        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json('invalid credentials', 401);
        }

        
        $token = $user->createToken('remember_token')->plainTextToken;

        return response()->json([
            'user'=>$user,
            'token'=>$token,
            'message'=>'logged in'
        ]);


    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message'=>'logged out successfully'
        ]);
    }
}
