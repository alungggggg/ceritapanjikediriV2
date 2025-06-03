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
            if ($request->id) {
                $nilai = nilaiModel::with("user", 'artikel')->find($request->id);
                if (!$nilai) {
                    return response()->json([
                        'message' => 'Nilai not found',
                    ], 404);
                }
                return response()->json([
                    'success' => true,
                    'data' => $nilai
                ], 200);
            } else if ($request->id_artikel) {
                $nilai =  artikelModel::with('nilai')
                    ->where('id', $request->id_artikel)
                    ->get();
                if ($nilai->isEmpty()) {
                    return response()->json([
                        'message' => 'Nilai not found for the given article ID',
                    ], 404);
                }
            } else if ($request->id_user) {
                $nilai = nilaiModel::with('user', 'artikel')->where('id_user', $request->id_user)->get();
                if ($nilai->isEmpty()) {
                    return response()->json([
                        'message' => 'Nilai not found for the given article ID',
                    ], 404);
                } else {
                    return response()->json([
                        'success' => true,
                        'data' => $nilai
                    ]);
                }
            } else {
                $nilai = nilaiModel::with('artikel', 'user')->get();
                return response()->json([
                    'success' => true,
                    'data' => $nilai
                ], 200);
            }
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
