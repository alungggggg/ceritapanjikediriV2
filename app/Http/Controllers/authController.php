<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\JWT;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class authController extends Controller
{
    //

    public function updateProfile(Request $request, $id){
        try{
            User::find($id)->update($request);
            return response()->json(["message" => "Profile successfully update"], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function validJWT($token){
        try{

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function isAvailableUsername(Request $request){
        try{
            $user = User::where('username', $request->search)->first();
            if($user){
                return response()->json(["isAvailable" => false]);
            }
            return response()->json(["isAvailable" => true]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function verify($token){
        try{

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function register(){
        
    }

    public function forgotPasswordSend(){

    }

    public function isAvailableEmail(Request $request){
        try{
            $user = User::where('email', $request->search)->first();
            if($user){
                return response()->json(["isAvailable" => false], 200);
            }
            return response()->json(["isAvailable" => true], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function checkEmail(Request $request){
        try{
            $user = User::where('email', $request->search)->first();
            if($user){
                return response()->json(["checkEmailExist" => true], 200);
            }
            return response()->json(["checkEmailExist" => false], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function login(Request $request){
        try{
            $usernameOrEmail = $request->credential;
            $password = $request->password;
            $user = User::where('username', $usernameOrEmail)->orWhere('email', $usernameOrEmail)->first();
            if(!$user){
                return response()->json(["status" => false, "message" => "Cresential Is incorrect"], 422);
            }

            if(!password_verify($password, $user->password)){
                return response()->json(["status" => false, "message" => "Cresential Is incorrect"], 422);
            }

            if(!$user->isActive != 1){
                return response()->json(["status" => false, "message" => "Your account is not active"], 422);
            }

            $payload = [
                "id" => $user->id,
                "role" => $user->role,
                "refreshToken" => $user->refreshToken,
            ];

            return response()->json(["data" => [
                "id" => $payload["id"], "status" => true,], "token"]
            , 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function getAccessToken($user){  
        $payload = [
            'id' => $user->id,
            'exp' => time() + 60 * 60,
        ];
        $token = JWTAuth::fromUser($user, $payload);
        return $token;
    }

    public function getRefreshToken($id){
        try{
            $user = User::find($id);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function logout(){
        return response()->json(["status" => true], 200);
    }

    public function authenticationToken(){

    }

    public function testAuthToken(){
        return response()->json(["status" => true], 200);
    }

    public function refreshNewToken(){

    }

    public function forgotPaswordForm(){

    }
}
