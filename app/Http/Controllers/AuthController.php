<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function login(Request $request){

        $credentials=$request->only(["email","password"]);
        if(AUTH::attempt($credentials)){
             
            $user=Auth::user();
            $token=$user->createToken("Authtoken")->plainTextToken;
        
                    return response()->json([
                        "status"=>true,
                        "token"=>$token,
                        "message"=>"User Logged in succefully",
                        "data"=>$user
                    ]);
        }
        else{
            return response()->json([
                "status"=>false,
                "message"=>"Wrong Email or Password"
            ]);
        }
        
        }
        
        
         public function register(RegistrationRequest $request){
                
                $user=User::where("email",$request->email)->first();
                 if(is_null($user)){
        
                    $user=new User();
                    $user->name=$request->get("name");
                    $user->email=$request->get("email");
                    $user->phoneNumber=$request->get("phoneNumber");
                    $user->password=bcrypt($request->get("password"));
                    $user->save();
                    $token=$user->createToken("Authtoken")->plainTextToken;
        
                    return response()->json([
                        "status"=>true,
                        "token"=>$token,
                        "data"=>$user
                    ]);
                 }else{
                      return response()->json([
                        "status"=>false
                      ]);
                 }
                
        
            }
}
