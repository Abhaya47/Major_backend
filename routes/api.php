<?php
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\UserFeature;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//public routes

Route::post('/register', [UserController::class,'register']);
Route::post('/login', [UserController::class,'login']);
//protected routes
Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::get('/food',[FoodController::class,'consumedfood']);
    Route::post('/food',[FoodController::class,'save']);
    Route::put('/food',[FoodController::class,'update']);
    Route::delete('/food/{id}',[FoodController::class,'destroy']);


    Route::get('/ufeature',[UserFeature::class,'view']);
    Route::post('/ufeature',[UserFeature::class,'add']);
    Route::put('/ufeature',[UserFeature::class,'update']);
    Route::delete('/ufeature',[UserFeature::class,'destroy']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
