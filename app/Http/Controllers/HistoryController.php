<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\historyModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function setHistory(Request $request){
        $id = Auth::id();
        HistoryModel::updateOrInsert(
            [
                "id_user" => $id,
                "id_dongeng" => $request->id_dongeng
            ],
        );

        return response()->json(["message" => "success"], 200);
    }
    //
    public function getHistory()
    {
        $targetVector = null;

        $dataSet = Self::getheringHistory(User::with(['history'])->get());
        $dongengList = Self::getDongeng($dataSet);
        $userVectors = array_values(array_map(function ($user) use ($dongengList) {
            return [
                'id_user' => $user['id_user'],
                'vector' => Self::createUserVector($user, $dongengList)
            ];
        }, $dataSet));
        
        
        foreach ($userVectors as $user) {
            if ($user['id_user'] == Auth::id()) {
                $targetVector = $user['vector'];
                break;
            }
        }
        
        $similarities = [];
        
        foreach ($userVectors as $user) {
            if ($user['id_user'] == Auth::id()) continue;
            
            $similarity = Self::cosineSimilarity($targetVector, $user['vector']);
            
            $similarities[] = [
                'id_user' => $user['id_user'],
                'similarity' => $similarity
            ];
        }
        
        $similarities = Self::order($similarities, 'similarity'); 
        
        $historyRecommend = historyModel::with(['dongeng'])->whereIn('id_user', Self::getUserId($similarities))->get();
        $history=[];
        foreach (User::with(['history'])->find(Auth::id())["history"] as $value) {
            $history[] = $value->id_dongeng;
        }
        $result = array_slice(Self::order(Self::historyComparer($history, $historyRecommend), 'view'), 0, 5);
        return response()->json([$result], 200);

    }

    public function historyComparer($history, $recommend){
        $result = [];

        foreach($history as $value){
            foreach($recommend as $rec){
                if($value != $rec->id_dongeng && !in_array($rec->dongeng, $result)){
                    $result[] = $rec->dongeng;
                }
                
            }
        }
        return $result;
    }

    public function getUserId($similarities){
        $id_user = [];
        foreach($similarities as $user){
            $id_user[] = $user['id_user'];
        }
        return $id_user;
    }

    public function order($similarities, $type){
        usort($similarities, function ($a, $b) use ($type) {
            return $b[$type] <=> $a[$type];
        });

        return $similarities;
    }
    
    public function getDongeng($dataSet){
        $allDongeng = [];
        foreach ($dataSet as $user) {
            foreach ($user['id_dongeng'] as $dongeng) {
                $allDongeng[] = $dongeng;
            }
        }
        return array_values(array_unique($allDongeng));
    }

    public function createUserVector($user, $dongengList) {
        return array_map(function ($dongeng) use ($user) {
            return in_array($dongeng, $user['id_dongeng']) ? 1 : 0;
        }, $dongengList);
    }

    function cosineSimilarity($vecA, $vecB) {
        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;

        for ($i = 0; $i < count($vecA); $i++) {
            $dotProduct += $vecA[$i] * $vecB[$i];
            $magnitudeA += $vecA[$i] ** 2;
            $magnitudeB += $vecB[$i] ** 2;
        }

        $magnitudeA = sqrt($magnitudeA);
        $magnitudeB = sqrt($magnitudeB);

        if ($magnitudeA == 0 || $magnitudeB == 0) return 0;
        return $dotProduct / ($magnitudeA * $magnitudeB);
    }

    public function getheringHistory($users){
        $results = [];

        foreach ($users as $user) {
            $userHistory = [];
            $userHistory['id_user'] = $user->id;
            $userHistory['id_dongeng'] = [];

            foreach ($user->history as $history) {
                $userHistory['id_dongeng'][] = $history->id_dongeng;
            }

            $results[] = $userHistory;
        }
        return $results;
    }
}