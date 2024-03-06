<?php

namespace App\Http\Controllers;

use App\Models\Features;
use Illuminate\Http\Request;
use App\Http\Controllers\UserFeature;
use Illuminate\Support\Facades\Auth;

class MakeRecommendation extends Controller
{

    public function calculate_caloric_needs($gender, $weight, $height, $age)
    {
        //    weight_kg (float): Weight in kilograms
        //    age_years (int): Age in years
        //    height_cm (float): Height in centimeters
        //    gender (str): Gender of the user ("male" or "female")
        //
        //    Returns:
        //    float: Estimated daily caloric needs

        if ($gender == "male") {
            $bmr = 88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age);
        } else {
            $bmr = 447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age);
        }
        # Assuming moderate activity level
        return $bmr * 1.55;
    }

//    public function get_dietary_need()
//    {
//        $user = Auth::user();
//        $ufeature = Features::query()->where('uid', '=', $user->id)->get();
//        $gender = $ufeature[0]["gender"];
//        $weight = $ufeature[0]["weight"];
//        $pressure = $ufeature[0]["pressure"];
//        $sugar = $ufeature[0]["sugar"];
//        $age = $ufeature[0]["age"];
//        $height = $ufeature[0]["height"] * 100;
//        # Calculate caloric needs
//        $dailyCalories = $this->calculate_caloric_needs($gender, $weight, $height, $age);
//        $dailyCarbs = $dailyCalories * 0.55 / 4;
//        $dailyProtein = $weight * 1.2;
//        $fat = $dailyCalories * 0.25 / 9;
//        $need= [$dailyCalories*0.4, $pressure,$sugar];
//        return($need);
//    }

    public function getRequest()
    {
        $user = Auth::user();
        $ufeature = Features::query()->where('uid', '=', $user->id)->get();
        $gender = $ufeature[0]["gender"];
        $weight = $ufeature[0]["weight"];
        $pressure = $ufeature[0]["pressure"];
        $sugar = $ufeature[0]["sugar"];
        $age = $ufeature[0]["age"];
        $height = $ufeature[0]["height"] * 100;
        # Calculate caloric needs
        $dailyCalories = $this->calculate_caloric_needs($gender, $weight, $height, $age);
        $dailyCarbs = $dailyCalories * 0.55 / 4;
        $body = [$dailyCalories * 0.4, $pressure, $sugar];
        $body = json_encode($body);
        $command = "python3.8 /var/www/Major_backend/app/Http/Controllers/recommendor.py $body";
        $output = exec($command, $outputArray, $returnCode);
        $raw=(json_decode($outputArray[1],true));
        $newArray=[];
        foreach($raw["data"] as $item){
            $newArray[]=[
                "Name"=>$item[0],
                "Calories"=>$item[1],
                 "FatContent"=>$item[2],
                 "SaturatedFatContent"=>$item[3],
                 "CholesterolContent"=>$item[4],
                 "SodiumContent"=>$item[5],
                 "CarbohydrateContent"=>$item[6],
                 "FiberContent"=>$item[7],
                 "SugarContent"=>$item[8],
                 "ProteinContent"=>$item[9],
                 "type"=>$item[10]
            ];
        }
        return response()->json($newArray);
    }}

