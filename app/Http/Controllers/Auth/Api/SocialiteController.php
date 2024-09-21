<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Models\Auth\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

    // ------------------ Google --------------------


    // Authentication Google Redirects
    // public function redirectToGoogle(){
    //     return Socialite::driver('google')->redirect();
    // }


    // Handel Auth Google
    // public function handleGoogleCallback(Request $request){
    //     try{

    //         // Select Google Driver
    //         $user = Socialite::driver('google')->user();

    //         // Check User Is Found Or Not
    //         $findUser = User::where('socialite_id',$user->id)->first();

    //         // If User Found Go To Login
    //         if($findUser){
    //             Auth::login($findUser);
    //             return response()->json($findUser);
    //         }

    //         // if not found User
    //         $newUser = User::create([
    //             'name' => $user->name,
    //             'email' => $user->email,
    //             'password' => Hash::make('engine-store-google-auth'),
    //             'social_type' => 'google',
    //             'social_id' => $user->id
    //         ]);
    //         // Login User And Return Data
    //         Auth::login($newUser);
    //         return response()->json($newUser);

    //     }catch(\Exception $e){
    //         dd($e->getMessage());
    //     }
    // }

    // ------------------ Facebook --------------------


    // // Authentication facebook Redirects
    //  public function redirectToFacebook(){
    //     return Socialite::driver('facebook')->redirect();
    // }

     // Universal Redirect to Socialite Driver
     public function redirectToProvider(string $driver)
     {
         return Socialite::driver($driver)->redirect();
     }

      // Universal Socialite Callback Handler
    public function handleProviderCallback(Request $request, string $driver, string $model)
    {
        try {
            // Retrieve user from provider
            $socialUser = Socialite::driver($driver)->user();

            // Determine model to use
            $userModel = $this->getUserModel($model);

            // Check if user exists
            $user = $userModel::where('social_id', $socialUser->id)->first();

            if ($user) {
                // Log the user in
                Auth::login($user);
            } else {
                // Create new user if not exist
                $user = $userModel::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'password' => Hash::make($driver . $socialUser->id),
                    'social_type' => $driver,
                    'social_id' => $socialUser->id
                ]);

                // Log the new user in
                Auth::login($user);
            }

            return response()->json($user);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Determine which user model to use
    protected function getUserModel(string $model)
    {
        return $model === 'admin' ? Admin::class : User::class;
    }


}
