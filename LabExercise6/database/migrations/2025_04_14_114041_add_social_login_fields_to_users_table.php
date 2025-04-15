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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable();
            $table->string('google_token')->nullable();
            $table->string('google_refresh_token')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('facebook_token')->nullable();
            $table->string('facebook_refresh_token')->nullable();
            $table->string('microsoft_id')->nullable();
            $table->string('microsoft_token')->nullable();
            $table->string('microsoft_refresh_token')->nullable();
            $table->string('linkedin_id')->nullable();
            $table->string('linkedin_token')->nullable();
            $table->string('linkedin_refresh_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'google_id',
                'google_token',
                'google_refresh_token',
                'facebook_id',
                'facebook_token',
                'facebook_refresh_token',
                'microsoft_id',
                'microsoft_token',
                'microsoft_refresh_token',
                'linkedin_id',
                'linkedin_token',
                'linkedin_refresh_token'
            ]);
        });
    }
};
