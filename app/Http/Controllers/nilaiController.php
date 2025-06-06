<?php

namespace App\Http\Controllers;

use App\Models\artikelModel;
use App\Models\nilaiModel;
use Illuminate\Http\Request;

class nilaiController extends Controller
{
    //
    public function getNilai(Request $request)
    {
        try {
            if ($request->id_nilai) {
                $nilai = nilaiModel::with(['artikel'])->find($request->id);
                if (!$nilai) {
                    return response()->json([
                        'message' => 'Nilai not found',
                    ], 404);
                }
                return response()->json([
                    'success' => true,
                    'data' => $nilai
                ], 200);
            }

            if ($request->id_artikel) {
                $artikel = artikelModel::with('nilai.user')
                    ->where('id', $request->id_artikel)
                    ->first();

                if (!$artikel) {
                    return response()->json([
                        'message' => 'Artikel not found',
                    ], 404);
                }

                return response()->json([
                    'success' => true,
                    'data' => $artikel
                ], 200);
            }



            // Ambil semua nilai dengan data artikel & user
            $artikel = artikelModel::with('nilai.user')->get();
            if (!$artikel) {
                return response()->json([
                    'message' => 'Artikel not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $artikel
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function createNilai(Request $request)
    {
        try {
            $nilai = nilaiModel::create($request->all());
            return response()->json([
                'success' => true,
                'data' => $nilai
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function updateNilai(Request $request, $id)
    {
        try {
            $nilai = nilaiModel::find($id);
            if (!$nilai) {
                return response()->json([
                    'message' => 'Nilai not found',
                ], 404);
            }
            $nilai->update($request->all());
            return response()->json([
                'success' => true,
                'data' => $nilai
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function deleteNilai($id)
    {
        try {
            $nilai = nilaiModel::find($id);
            if (!$nilai) {
                return response()->json([
                    'message' => 'Nilai not found',
                ], 404);
            }
            $nilai->delete();
            return response()->json([
                'success' => true,
                'message' => 'Nilai deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
