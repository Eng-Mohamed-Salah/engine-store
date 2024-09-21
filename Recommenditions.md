## Libraries For Need To Install Project 
- [1] Install Is : 
    - install Telescope For Development Project :  [✅] 
        1. `composer require laravel/telescope --dev` 
        2. `php artisan telescope:install`
        3. `php artisan migrate`
        
    - install Passport For Production : [✅]
        1. `composer require laravel/passport`
        2. `php artisan install:api --passport`
        3. `php artisan passport:install`
        4. `php artisan passport:keys`
        5. `php artisan vendor:publish --tag=passport-config`
        6. `php artisan passport:client --personal`

        
    - install Socialite : [✅]
        1. `composer require laravel/socialite`
        2. add in File config/services.php : 
        ```
        'github' => [
            'client_id' => env('GITHUB_CLIENT_ID'),
            'client_secret' => env('GITHUB_CLIENT_SECRET'),
            'redirect' => 'http://example.com/callback-url',
        ],
        ```
