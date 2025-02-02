<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\soalUraianPanjangModel;

class UraianPanjangController extends Controller
{
    //
    public function createSoalUraianPanjang(Request $request){
        try{
            soalUraianPanjangModel::create([
                "id" => Uuid::uuid4(),
                "soal" => $request->soal,
                "idDongeng" => $request->idDongeng,
                "jawaban" => $request->jawaban
            ]);
            return response()->json(["message" => "soal uraian panjang created"], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function getSoalUraianPanjang(){
        try{
            return response()->json(soalUraianPanjangModel::with("dongeng")->get(), 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }
    public function updateSoalUraianPanjang(Request $request, $id){
        try{
            $data = soalUraianPanjangModel::find($id);
            if(!$data){
                return response()->json(["message" => "Soal Uraian Panjang not found"], 404);
            }
            // "id" => Uuid::uuid4(),
            //     "soal" => $request->soal,
            //     "idDongeng" => $request->idDongeng,
            //     "jawaban" => $request->jawaban
            // $data->id = Uuid::uuid4();
            $data->soal = $request->soal;
            $data->idDongeng = $request->idDongeng;
            $data->jawaban = $request->jawaban;

            $data->save();

            return response()->json(["message" => "Soal Uraian Panjang Updated!"], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function deleteSoalUraianPanjang($id){
        try{
            $data = soalUraianPanjangModel::where("id" ,$id)->first();
            $data->delete();
            return response()->json(["message" => "Soal Uraian Panjang Deleted!"], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }
}
