<?php

namespace App\Http\Controllers;
use App\Models\Food;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\throwException;

class FoodController extends Controller
{
    public function consumedfood(Request $request){
        $user = Auth::user();
        $request=json_decode($request->getContent(),true);
        $date=$this->validate_date($request['date']);
        $food=Food::query()->whereDate( 'consumed_time','=',$date)->where('uid','=',$user->id)->get();
        return response(json_encode($food),200);

    }

    public function save(Request $request){
        $validatedData = $request->validate([
            'name'=>'required|string',
            'calorie'=>'string',
            'description'=>'nullable|string'
        ]);
        $food=new Food();
        $food->name=$validatedData['name'];
        $food->calorie=$validatedData['calorie'];
        $food->description=$validatedData['description'];
        $user = Auth::user();
        $food->uid=$user->id;
        $food->save();
        return response('',200);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id'=>'required',
            'name'=>'required|string',
            'calorie'=>'string',
            'description'=>'nullable|string'
        ]);
        $food=Food::find($validatedData['id']);
        if($food==null){
            return response('',401);
        }
        $food->name=$validatedData['name'];
        $food->calorie=$validatedData['calorie'];
        $food->description=$validatedData['description'];
        $user = Auth::user();
        $food->uid=$user->id;
        $food->save();
        return response('',200);
    }


    public function destroy($id)
    {
        $food=Food::find($id);
        $food->delete();
        return $food;
    }

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
