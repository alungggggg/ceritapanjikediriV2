<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    //


    public function createUser(Request $request)
    {  
        // -jwt
        try{
            $validator = Validator::make($request->all(), [
                'nama' => '',
                'username' => 'unique:users,username',
                'email' => 'unique:users,email',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $request->password = Hash::make($request->password);
        }catch(\Exception $e){
            
        }
    }

    public function getUser()
    {
        try{
            return response()->json(User::all(), 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function getUserById($id)
    {
        try{
            return response()->json(User::find($id), 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function updateUser(Request $request, $id){
        try{
            $data = User::find($id);
            if($request->password){
                $data->password = Hash::make($request->password);
            }
            $data->nama = $request->nama;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->kelas = $request->kelas;
            $data->sekolah= $request->sekolah;

            $data->save();

            return response()->json(["message" => "user berhasil diupdate"], 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function deleteUser($id){
        try{
            $user = User::find($id);
            $user->delete();
            
            return response()->json(["message" => "berhasil delete user"], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return response()->json($user, 200);
    }

    public function updateProfile(Request $request, $id){
        try{
            User::find($id)
            ->update($request);
            return response()->json([ "message" => 'berhasil mengupdate Profile'], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }

    }
}
