<?php

namespace App\Http\Controllers;

use App\Models\artikelModel;
use Illuminate\Http\Request;

class artikelController extends Controller
{
    //
    public function getArtikel(Request $request)
    {
        try {
            if($request->id){
                $artikel = artikelModel::find($request->id);
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
            $artikel = artikelModel::all();
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

    public function createArtikel(Request $request)
    {
        try {
            $artikel = artikelModel::create($request->all());
            return response()->json([
                'success' => true,
                'data' => $artikel
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function updateArtikel(Request $request, $id)
    {
        try {
            $artikel = artikelModel::find($id);
            if (!$artikel) {
                return response()->json([
                    'message' => 'Artikel not found',
                ], 404);
            }
            $artikel->update($request->all());
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
    public function deleteArtikel($id)
    {
        try {
            $artikel = artikelModel::find($id);
            if (!$artikel) {
                return response()->json([
                    'message' => 'Artikel not found',
                ], 404);
            }
            $artikel->delete();
            return response()->json([
                'success' => true,
                'message' => 'Artikel deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
