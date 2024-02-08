<?php

namespace App\Http\Controllers;

use App\Models\Features;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFeature extends Controller
{
    //

    public function add(Request $request)
    {
        $validatedData=$request->validate([
            'weight'=>'required',
            'height'=>'required',
            'pressure'=>'nullable'
        ]);
        $user= Auth::user();
        $ufeature=new Features();
        $ufeature->weight=$validatedData['weight'];
        $ufeature->height=$validatedData['height'];
        $ufeature->pressure=$validatedData['pressure'];
        $ufeature->bmi=$validatedData['weight']/($validatedData['height']*$validatedData['height']);
        $ufeature->uid=$user->id;
        $ufeature->save();
        return response('',200);
    }

    public function update(Request $request){
        $validatedData=$request->validate([
            'weight'=>'required',
            'height'=>'required',
            'pressure'=>'nullable'
        ]);
        $user= Auth::user();
        $uid=$user->id;
        $ufeature=Features::query()->where('uid','=',$uid)->first();
        $ufeature->weight=$validatedData['weight'];
        $ufeature->height=$validatedData['height'];
        $ufeature->pressure=$validatedData['pressure'];
        $ufeature->bmi=$validatedData['weight']/($validatedData['height']*$validatedData['height']);
        $ufeature->save();
        return response('',200);
    }

    public function view(){
        $user = Auth::user();
        $ufeature=Features::query()->where('uid','=',$user->id)->get();
        return response(json_encode($ufeature),200);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $ufeature=Features::find($id);
        $ufeature->delete();
        return $ufeature;
    }

}
