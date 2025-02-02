<?php

namespace App\Http\Controllers;

use App\Models\soalUraianSingkatModel;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class uraianSingkatController extends Controller
{
    //
    public function createSoalUraianSingkat(Request $request){
        try{
            soalUraianSingkatModel::create([
                "id" => Uuid::uuid4(),
                "soal" => $request->soal,
                "idDongeng" => $request->idDongeng,
                "jawaban" => $request->jawaban
            ]);

            return response()->json(["message" => "Soal Uraian Singkat Created"]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function getSoalUraianSingkat()
    {
        try{
            return response()->json(soalUraianSingkatModel::with('dongeng')->get(), 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function updateSoalUraianSingkat(Request $request, $id){
        try{
            $data = soalUraianSingkatModel::find($id);
            if(!$data){
                return response()->json(["message" => "Soal Uraian Singkat not found"]);
            }

            $data->update($request->all());
            return response()->json(["message" => "soal uraian singkat updated"]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function deleteSoalUraianSingkat($id)
    {
        try{
            soalUraianSingkatModel::find($id)->delete();
            return response()->json(["message" => "Soal Uraian Singkat Deleted"]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }
}
