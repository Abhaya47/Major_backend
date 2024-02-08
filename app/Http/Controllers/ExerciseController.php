<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Food;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    public function exercisedone(Request $request){
        $user = Auth::user();
        $request=json_decode($request->getContent(),true);
        $date=$this->validate_date($request['date']);
        $exercise=Exercise::query()->whereDate( 'performed_time','=',$date)->where('uid','=',$user->id)->get();
        return response(json_encode($exercise),200);
    }

    public function save(Request $request){
        $validatedData = $request->validate([
            'name'=>'required|string',
            'reps'=>'integer',
            'description'=>'nullable|string'
        ]);
        $exercise=new Exercise();
        $exercise->name=$validatedData['name'];
        $exercise->calorie=$validatedData['reps'];
        $exercise->description=$validatedData['description'];
        $user = Auth::user();
        $exercise->uid=$user->id;
        $exercise->save();
        return response('',200);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id'=>'required',
            'name'=>'required|string',
            'reps'=>'integer',
            'description'=>'nullable|string'
        ]);
        $exercise=Exercise::find($validatedData['id']);
        if($exercise==null){
            return response('',401);
        }
        $exercise->name=$validatedData['name'];
        $exercise->calorie=$validatedData['reps'];
        $exercise->description=$validatedData['description'];
        $user = Auth::user();
        $exercise->uid=$user->id;
        $exercise->save();
        return response('',200);
    }

    public function destroy($id)
    {
        $exercise=Exercise::find($id);
        $exercise->delete();
        return $exercise;
    }
    //
    private function validate_date($date){
        try{
            $date=Carbon::parse($date);
            if($date->isFuture()){
                header("Location:".route('food_take',Carbon::now()->format("Y-m-d")));
                die;
            }
        }
        catch(\Exception $e)
        {
            $date= Carbon::now();
        }
        return $date->format("Y-m-d");
    }
}
