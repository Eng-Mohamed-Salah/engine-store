<?php

use App\Http\Controllers\Auth\Api\SocialiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', action: function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::group(["prefix"=> "admin"], function () {
    Route::get('/test', function (Request $request) {
        return response()->json(['message' => 'test']);
    });

    // Redirect Google Auth
    Route::get('/auth/google',[SocialiteController::class,'redirectToProvider'])
    ->defaults('driver', 'google');

    Route::get('/auth/google/callback',[SocialiteController::class,'redirectToProvider'])
    ->defaults('driver', 'google')
    ->defaults('model', 'admin');


    // Redirect facebook Auth
    Route::get('/auth/facebook',[SocialiteController::class,'redirectToProvider'])
    ->defaults('driver', 'facebook');

    Route::get('/auth/facebook/callback',[SocialiteController::class,'redirectToProvider'])
    ->defaults('driver', 'facebook')
    ->defaults('model', 'admin');
});


