<?php

namespace App\Http\Controllers;

use App\Models\visitedModel;

class visitedController extends Controller
{
    //
    public function newVisited()
    {
        try{
            visitedModel::create();
            return response()->json(["Message" => "new visited"]);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }

    public function getAllVisited()
    {
        try{
            return response()->json(["visited" => visitedModel::all()->count()], 200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Internal Server Error: ' . $e->getMessage() ,
            ], 500);
        }
    }
}
