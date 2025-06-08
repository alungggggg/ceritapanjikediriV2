<?php

namespace App\Http\Controllers;

use App\Models\artikelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class artikelController extends Controller
{
    //
    public function getArtikel(Request $request)
    {
        try {
            if ($request->id) {
                $artikel = artikelModel::with('soal')->find($request->id);
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

            $artikel = artikelModel::with('soal')->get();
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
            $gambar = $request->file('gambar'); 
            $destinationPath = 'artikel/';
            $profileImage = date('YmdHis') . "." . $gambar->getClientOriginalExtension();
            $gambar->move($destinationPath, $profileImage);

            $artikel = artikelModel::create([
                'artikel_link' => $request->artikel_link,
                'judul' => $request->judul,
                'image' => $profileImage,
                'type' => $request->type,
                'deskripsi' => $request->deskripsi,
            ]);
           
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
            $data = artikelModel::find($id);
            if (!$data) {
                return response()->json([
                    'message' => 'Artikel not found',
                ], 404);
            }
            $data->artikel_link = $request->artikel_link;
            $data->judul = $request->judul;
            $data->deskripsi = $request->deskripsi;
            $data->type = $request->type;
            if($request->file("gambar"))
            {
                if (File::exists("artikel/" . $data['image'])) {
                    File::delete("artikel/" . $data['image']);
                }

                $gambar = $request->file('gambar'); 
                $destinationPath = 'artikel/';
                $filename = date('YmdHis') . "." . $gambar->getClientOriginalExtension();
                $gambar->move($destinationPath, $filename);

                $data->image = $filename;
            }
            $data->save();

            return response()->json([
                'success' => true,
                'data' => $data
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
            $data = artikelModel::find($id);
            if (File::exists("artikel/" . $data['image'])) {
                File::delete("artikel/" . $data['image']);
            }
            if (!$data) {
                return response()->json([
                    'message' => 'Artikel not found',
                ], 404);
            }
            $data->delete();
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
