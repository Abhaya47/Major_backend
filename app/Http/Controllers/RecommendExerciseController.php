<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecommendExerciseController extends Controller
{
    //
    public function recommend(){
//        $request=json_decode($request->getContent(),true);
        $body="Legs";
        $command="python3.8 /var/www/Major_backend/app/Http/Controllers/trying.py  $body";
        $output=exec($command,$outputArray,$returnCode);
        if ($returnCode == 0) {

        } else {
            echo "Error executing Python script.\n";
            return(response(status: 500));
        }
        $output=($outputArray);
        return response(json_encode($output));
    }
}
