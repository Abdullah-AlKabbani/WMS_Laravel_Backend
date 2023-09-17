<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function test()
    {
        return response()->json([
            "message"=>"hello"
        ]);
    }

    public function register(Request $request)
    {
        try{
            $request->validate([
                "email" => "required|unique:users",
                "password" => "required|confirmed",
                "type" => "required"
            ]);

            $user = new User();
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->phone_n = $request->phone_n;
            $user->type = $request->type;
            $user->save();

            $address = new Address();
            $address->country = $request->country;
            $address->city = $request->city;
            $address->district = $request->district;
            $address->user_id = $user->id;

            $address->save();

            return response()->json([
                "message" => "user created Successfully"
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // return custom error message for email field
            $errors = $e->validator->errors();
            $message = $errors->has('username') ? 'username must be unique.' : 'Username must be uniqe, Please enter another username';
            return response()->json([
                "message" => $message,
            ], 422);
        }
    }

   public function login(Request $request){

   $login_data = $request->validate([

        "email"=>"required",
        "password"=>"required",
       ]);

       if(!auth()->attempt( $login_data)){

        return response()->json([
         "status"=>false,
         "message"=>"invalid "
        ],400);
       }

       $token =auth()->user()->createToken("auth_token")->accessToken;
       $type = auth()->user()->type;
       return response()->json([
        "token"=> $token,
        "type"=> $type
       ],200);
   }


   public function logout(Request $request){


      $token = $request->user()->token();

      $token->revoke();

      return response()->json([
         "status"=>true,
         "message"=>"logged out successfully ",

        ],200);
   }


    //change password
    public function change(Request $request){

        $user = User::findOrFail( auth()->user()->id);
        $user->password =bcrypt($request->password);
        $user->save();

        return response()->json([
            "status"=>true,
            "message"=>"password change successfully ",

           ],200);
    }

}
