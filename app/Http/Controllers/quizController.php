<?php

namespace App\Http\Controllers;

use App\Models\forumQuizModel;
use App\Models\rekapNilaiModel;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class quizController extends Controller
{
    //
    function generateRandomString($length = 6) {
        return substr(str_shuffle(str_repeat($x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', ceil($length / strlen($x)))), 1, $length);
    }

    public function createQuiz(Request $request){
        try{
            forumQuizModel::create([
                "id" => Uuid::uuid4(),
                "judul" => $request->judul,
                "idDongeng" => $request->idDongeng,
                'sekolah' => $request->sekolah,
                "access_date" => $request->access_date,
                "expired_date" => $request->expired_date,
                "token" => self::generateRandomString()
            ]);

            return response()->json(["message" => "berhasil membuat quiz"], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function getAllQuiz(){
        try{
            return response()->json(forumQuizModel::with([
                'dongeng' => function ($query) {
                    $query->with([
                        'soalPilgan',
                        'soalUraianSingkat',
                        'soalUraianPanjang'
                    ]);
                }])->get(), 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function getQuizById($id){
        try{
            return response()->json(forumQuizModel::where("id",$id)
            ->with([
                'dongeng' => function ($query) {
                    $query->with([
                        'soalPilgan',
                        'soalUraianSingkat',
                        'soalUraianPanjang'
                    ]);
                }])->first(), 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function updateQuiz(Request $request, $id){
        try{
            $item = forumQuizModel::find($id);
            if(!$item){
                return response()->json(["message" => "quiz not found"], 404);
            }

            $item->update($request->all());
            return response()->json(["message" => "quiz updated"]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function deleteQuiz($id){
        try{
            forumQuizModel::where("id", $id)->delete();
            rekapNilaiModel::where("id_Forum",$id)->delete();
            return response()->json(["message" => "Quiz Deleted"]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
        
    }

    
}
