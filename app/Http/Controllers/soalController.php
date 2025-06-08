<?php

namespace App\Http\Controllers;

use App\Models\artikelModel;
use App\Models\soalModel;
use Illuminate\Http\Request;

class soalController extends Controller
{
    //

    public function getSoal(Request $request)
    {
        try {
            $soal = [];
            if($request->id_artikel){
                $soal = artikelModel::with('soal')
                    ->where('id', $request->id_artikel)
                    ->get();
                if ($soal->isEmpty()) {
                    return response()->json([
                        'message' => 'Soal not found for the given article ID',
                    ], 404);
                }
                return response()->json([
                    'success' => true,
                    'data' => $soal
                ], 200);
            }
            if($request->id){
                $soal = soalModel::find($request->id);
                if (!$soal) {
                    return response()->json([
                        'message' => 'Soal not found',
                    ], 404);
                }
                
            }
            $soal = soalModel::with('artikel')->get();

            return response()->json([
                'success' => true,
                'data' => $soal
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function createSoal(Request $request)
    {
        try {
            $soal = soalModel::create($request->all());
            return response()->json([
                'success' => true,
                'data' => $soal
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function updateSoal(Request $request, $id)
    {
        try {
            $soal = soalModel::find($id);
            if (!$soal) {
                return response()->json([
                    'message' => 'Soal not found',
                ], 404);
            }
            $soal->update($request->all());
            return response()->json([
                'success' => true,
                'data' => $soal
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function deleteSoal($id)
    {
        try {
            $soal = soalModel::find($id);
            if (!$soal) {
                return response()->json([
                    'message' => 'Soal not found',
                ], 404);
            }
            $soal->delete();
            return response()->json([
                'success' => true,
                'message' => 'Soal deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    
}
