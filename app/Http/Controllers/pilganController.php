<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\soalPilganModel;

class pilganController extends Controller
{
    //
    public function createSoalPilgan(Request $request){
        try{
            soalPilganModel::create([
                "id" => Uuid::uuid4(),
                "soal" => $request->soal,
                "idDongeng" => $request->idDongeng,
                "opsi_1" => $request->opsi_1,
                "opsi_2" => $request->opsi_2,
                "opsi_3" => $request->opsi_3,
                "opsi_4" => $request->opsi_4,
                "jawaban" => $request->jawaban
            ]);

            return response()->json(["message" => "Soal Pilihan Ganda Created!"], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function getSoalPilgan(){
        try{
            return response()->json(soalPilganModel::with("dongeng")->get(), 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function updateSoalPilgan(Request $request, $id){
        try{
            $data = soalPilganModel::find($id);
            if(!$data){
                return response()->json(["message" => "Soal Pilihan Ganda not found"], 404);
            }
            $data->update($request->all());

            return response()->json(["message" => "Soal Pilihan Ganda Updated!"], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function deleteSoalPilgan($id){
        try{
            $data = soalPilganModel::find($id);
            $data->delete();

            return response()->json(["message" => "Soal Pilihan Ganda Deleted!"], 200);
            
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }
}
