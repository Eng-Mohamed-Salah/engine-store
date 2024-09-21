<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Client;
class PassportPersonalAccessClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Check if Personal Access Client exists, if not, create one
        if (!Client::where('password_client', false)->where('personal_access_client', true)->exists()) {
            Artisan::call('passport:client', ['--personal' => true]);
        }
    }
}
