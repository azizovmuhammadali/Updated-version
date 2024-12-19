<?php

use App\Http\Controllers\FindController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\UserController as UserControllerV1;
use App\Http\Controllers\V2\UserController as UserControllerV2;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('v1')->group(function () {
    Route::apiResource('user', UserControllerV1::class);
});

Route::prefix('v2')->group(function () {
    Route::apiResource('user', UserControllerV2::class);
});
Route::get('search',[FindController::class,'FindMethod']);