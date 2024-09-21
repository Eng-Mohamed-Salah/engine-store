<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create Fields For Table User
        Schema::table('users', function (Blueprint $table) {
            $table->string('social_id')->nullable()->after('email'); // فرض أن حقل البريد الإلكتروني موجود بالفعل
            $table->string('social_type')->nullable()->after('social_id');
        });

        // Create Fields For Table Admin
        Schema::table('admins', function (Blueprint $table) {
            $table->string('social_id')->nullable()->after('email'); // فرض أن حقل البريد الإلكتروني موجود بالفعل
            $table->string('social_type')->nullable()->after('social_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Down Table User
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['social_id', 'social_type']);
        });

        // Down Table Admin
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['social_id', 'social_type']);
        });
    }
};
