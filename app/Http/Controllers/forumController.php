<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Models\forumQuizModel;
use Ramsey\Uuid\Uuid;
use App\Models\rekapNilaiModel;

class forumController extends Controller
{
    //
    public function getRekapByForumId($id_forum)
    {
        try{
            return response()->json(
                rekapNilaiModel::join('users', 'users.id', '=', 'rekapnilai.id_User')
                ->with(['user', 'forum']) // Load forumQuiz tanpa join
                ->where('id_Forum', $id_forum)
                ->orderBy('users.nama', 'ASC') // Sorting berdasarkan nama user
                ->select('rekapnilai.*') // Pilih semua kolom dari rekap_nilai
                ->get()
            ,200);    

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function joinForumByToken(Request $request){

        try{
            $forum = forumQuizModel::where('token', $request->token);
            if(!$forum){
                return response()->json(["message" => "invalid token"], 400);
            }else if(new DateTime($forum->expired_date) < now()){
                return response()->json(["message" => "token expired"]);
            }else if(new DateTime($forum->access_date) > now()){
                return response()->json(["message" => "token not yet avaliable"]);
            }
            // - if $result->id_User == $idUser
    
            $checkJoinStatus = rekapNilaiModel::where([
                "id_User" => $request->id_user,
                "id_Forum" => $forum["id"]
            ]);
    
            if($checkJoinStatus){
                return response()->json(['message' => "already join"]);
            }
    
            rekapNilaiModel::create([
                "id" => Uuid::uuid4(),
                "id_Forum" => $forum["id"],
                "id_User" => $request->id_user
            ]);
    
            return response()->json([
                "message" => "Success join forum",
                "data" => $forum
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function updateNilaiQuiz(Request $request){
        try{
            $data = rekapNilaiModel::find($request->id);
            $data->nilai = $request->nilai;
            $data->save();

            return response()->json([
                $data
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }
    public function getQuizByUserId($id_user)
    {
        try{
            return response()->json(rekapNilaiModel::with(['user', 'forum'])->where("id_User", $id_user)->get(), 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Internal Server Error: ' . $e->getMessage()], 500);
        }

    }
    public function getRekapById($id)
    {
        try{
            $data = rekapNilaiModel::find($id);
            return response()->json($data, 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }

    }
}
