<?php

namespace App\Http\Controllers;

use App\Models\Features;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendExerciseController extends Controller
{
    //
    public function recommend()
    {
//        $request=json_decode($request->getContent(),true);
        $user = Auth::user();
        $ufeature = Features::query()->where('uid', '=', $user->id)->get();
        $weight = $ufeature[0]["bmi"];
        $pressure = $ufeature[0]["pressure"];
        $sugar = $ufeature[0]["sugar"];
        $body = [$weight, $pressure, $sugar];
        $body = json_encode($body);
        $command = "python3.8 /var/www/Major_backend/app/Http/Controllers/trying.py $body";
        $output = exec($command, $outputArray, $returnCode);
        if ($returnCode == 0) {
            $front = ($outputArray[1]);
            $behind = ($outputArray[2]);
            preg_match_all('/\d+\.\d+/', $front, $matches);
            $numbers = $matches[0];
            preg_match_all("/'([^']+)'/", $behind, $matches);
            $words = $matches[1];
            $data = [
                "Duration" => $numbers[2],
                "Duration_2" => $numbers[3],
                "Duration_3" => $numbers[4],
                "Exercise_Name" => $words[0],
                "Exercise_Name_2" => $words[1],
                "Exercise_Name_3" => $words[2]
            ];
            return response($data);
        } else {
            echo "Error executing Python script.\n";
            return (response(status: 500));
        }
    }
    }
