<?php

use App\Http\Controllers\MMS\PackageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('packages')->group(function () {

    Route::get('/get-all-data', [PackageController::class, 'getAllData']);
    Route::post('/', [PackageController::class, 'store']);

});


Route::prefix('users')->group(function () {

    Route::post('/register', [UserController::class, 'register']);

});