<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Auth\Admin;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class AuthTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Test register functionality.
     *
     * @return void
     */
    public function test_register()
    {
        // Generate Faker Email
        $faker = \Faker\Factory::create();
        // Generate credentials For Register
        $data = [
            'name' =>  $faker->name,
            'email' =>  $faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];


        // Send Data To Api Register
        $response = $this->postJson('/api/v1/admin/register', $data);

        // Check For Response Success and Return Data
        $response->assertStatus(201)
            ->assertJsonStructure([
                'access_token',
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
            ]);

        // Check User In Database Admin
        $this->assertDatabaseHas('admins', [
            'email' => $data['email'],
        ]);
    }

    // /**
    //  * Test login functionality.
    //  *
    //  * @return void
    //  */
    public function test_login()
    {
        // Generate Faker Email
        $faker = \Faker\Factory::create();
        // Generate credentials for Register
        $user = Admin::create([
            'name' =>  $faker->name,
            'email' =>  $faker->unique()->safeEmail,
            'password' => Hash::make('password123'),
        ]);

        // Act as the user for testing purposes
        Passport::actingAs($user);

        // Pass Data User In Request
        $data = [
            'email' => $user->email,
            'password' => 'password123',
        ];



        // Send Data User To Api Login
        $response = $this->postJson('/api/v1/admin/login', $data);

        // Check For Response Success and Return Data
        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
            ]);
    }

    // /**
    //  * Test login with invalid credentials.
    //  *
    //  * @return void
    //  */
    public function test_login_invalid_credentials()
    {
        // Generate Faker Email
        $faker = \Faker\Factory::create();
        // Generate credentials For Register
        $user = Admin::create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('password123'),
        ]);

        // Pass Data Field User For Test Credentials
        $data = [
           'email' => $user->email,
            'password' => 'wrongpassword',
        ];
        // Send Data User To Api Login
        $response = $this->postJson('/api/v1/admin/login', $data);

        // Check For Response Success and Return Data
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid Credentials',
            ]);
    }
}
