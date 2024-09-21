<?php

use App\Http\Controllers\Auth\Api\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/google', [SocialiteController::class, 'redirectToProvider'])
    ->defaults('driver', 'google');

Route::get('/auth/google/callback', [SocialiteController::class, 'handleProviderCallback'])
    ->defaults('driver', 'google')
    ->defaults('model', 'admin');

Route::get('/auth/facebook', [SocialiteController::class, 'redirectToProvider'])
    ->defaults('driver', 'facebook');

Route::get('/auth/facebook/callback', [SocialiteController::class, 'handleProviderCallback'])
    ->defaults('driver', 'facebook')
    ->defaults('model', 'admin');
