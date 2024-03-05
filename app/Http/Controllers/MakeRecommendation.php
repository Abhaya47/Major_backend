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

    public function get_dietary_need()
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
        $dailyProtein = $weight * 1.2;
        $fat = $dailyCalories * 0.25 / 9;
        $need= [$dailyCalories, $fat, $sugar, $pressure, $dailyProtein, $dailyCarbs];
        return($need);
//        if (isset($ufeature[0]['pressure']) || array_key_exists('pressure', $ufeature)) {        # Dietary plan{
//            $Pflag=true;
//        }
//        if (isset($ufeature[0]['sugar']) || array_key_exists('sugar', $ufeature)){
//            $sflags=true;
//        }
//        if ($Pflag & $sflags){
//            $needs[] = [$dailyCalories, $fat, 0.00, 0.00, $dailyProtein, $dailyCarbs];
//        }
//        elseif($Pflag){
//            $needs[]=[$dailyCalories, $fat, 0.00, $dailyProtein, $dailyCarbs];
//        }
//        elseif ($sflags){
//            $needs[]=[$dailyCalories, $fat, 0.00, $dailyProtein, $dailyCarbs];
//        }
//        else{
//            $needs[]=[$dailyCalories, $fat, $dailyProtein, $dailyCarbs];
//        }
    }

    public function getRequest(){
        $frequency=3;
        $weightArray=[40,30,30];
//        $weightArray = json_decode($weight, true);
        $needs=$this->get_dietary_need();
        $i=0;
        while($frequency>0){
            $meal=[];
            foreach($needs as $onenutri){
                $meal[]=($onenutri*$weightArray[$i])/100;
            }
            if($meal[2]!=0 & $meal[3]!=0) {
                $mealneeds = array('calories' => round($meal[0],2), 'total_fat' => round($meal[1],2), 'sugar' =>$meal[2],'sodium' =>$meal[3],'protein' =>$meal[4],'carbs' =>round($meal[5],2));
            }
            if($meal[2]!=0 & $meal[3]==0){
                $mealneeds = array('calories' => round($meal[0],2), 'total_fat' => round($meal[1],2), 'sodium' =>$meal[3],'protein' =>$meal[4],'carbs' =>round($meal[5],2));
            }
            if($meal[2]==0 & $meal[3]!=0){
                $mealneeds = array('calories' => round($meal[0],2), 'total_fat' => round($meal[1],2), 'sugar' =>$meal[2],'protein' =>$meal[4],'carbs' =>round($meal[5],2));
            }
            if($meal[2]==0 & $meal[3]==0){
                $mealneeds = array('calories' => round($meal[0],2), 'total_fat' => round($meal[1],2), 'protein' =>$meal[4],'carbs' =>round($meal[5],2));
            }
            $recommends[$i]=$this->meal($mealneeds);
            $i++;
            $frequency--;
        }
    return response(json_encode($recommends));
    }

    function meal($mealneeds){
        $mealneeds=json_encode($mealneeds);
        $command="python3.8 /var/www/Major_backend/app/Http/Controllers/recommendor.py 2>&1 $mealneeds";
//        $command="python3.8 /var/www/Major_backend/app/Http/Controllers/recommendor.py 2>&1 $mealneeds";
        $output=exec($command,$outputArray,$returnCode);
        return($outputArray);

    }
}
