<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request){
      $user =  User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);
        $token = $user->createToken('auth-sanctum')->plainTextToken;
        return response()->json([
            'messgae' => 'Siz muvaffaqiyatli ro\'yhatdan o\'tdingiz',
            "token" => $token
        ],201);
    }
    public function login(UserLoginRequest $request){
        if (strlen($request->username) == 0 || strlen($request->password) == 0)
            return 'error';

        $user = User::where('username', $request->get('username'))->first();
        if (!$user)
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);
        if (!Hash::check($request->get('password'), $user->password))
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);

        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json(["token" => $token],200);
    }
    public function update(UserUpdateRequest $request,$id){
        if(Auth::user()->id != $id){
            return response()->json(["message" => ["errors" => ["Boshqa foydalanuvchi ma'lumotini  o'zgartirish uchun huquq yo'q!"]]],403);
        }
         User::where('id',$id)->first()
        ->update([
            'full_name' => $request->full_name,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);
        return response()->json(["message" => "Foydalanuvchi ma'lumoti yangilandi!"],200);
    }
    public function user_info(){
        return response()->json([
            'data' => auth()->user()
        ],200);
    }

}
