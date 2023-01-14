<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\HelperTrait;

class AuthController extends Controller
{
    use HelperTrait;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=>'validation error',
                'errors'=>$validator->errors()
            ],400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request['password']),
           
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'User Created Successfully',
            'token'=>$user->createToken("API TOKEN")->plainTextToken
        ],200);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'name' => 'required',
            'password' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=>'validation error',
                'errors'=>$validator->errors()
            ],400);
        }


        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            $authUser = Auth::user();
     
            return response()->json([
                'satuts' => true,
                'message' =>'User Logged In Sucessfully' ,
                'token' => $authUser->createToken("API TOKEN")->plainTextToken,
            ]);
        } else {
            return response()->json([
                'status'=> false,
                'message'=>'Unauthorized',
                'errors'=>$validator->errors()
            ],400);
        }
    }

}
