<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\DeletePosts;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function verifyOtp(Request $request){
        $validator=validator($request->all(), [
            'email'=>['required','email'],
            'otp'=>['required','numeric','digits:6']
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $user = User::where('email', $request->email)->first();
        if(! is_null($user)){
            if($user->otp_code == $request->otp){
                $user->otp = null;
                $user->otp_verified = date()->now();
                $user->save();
                $token=$user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'token' => $token,
                    'message' => 'User Verified Successfully',
                ],200);
            } 
            return response()->json([
                'message' => "Otp is wrong",
              ],400);
        }

        return response()->json([
            'message' => "User not found",
          ],400);
    }
    

    // public userCount (){
    //     $users=User::count();
    //     response()->json([
    //         'count'=>$users
    //     ])
    // }
}
