<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('users', function (Blueprint $table) {
    $table->id();

    // Role / type
    $table->string('user_type')->default('user'); // 'admin', 'user', etc.

    // Authentication
    $table->string('username')->unique();  // login username
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');

    // Name split
    $table->string('first_name')->nullable();
    $table->string('last_name')->nullable();

    // College (from select)
    $table->string('college')->nullable();

    // Extra profile fields
    $table->string('phone', 30)->nullable();
    $table->text('about')->nullable();
    $table->string('avatar_path')->nullable(); // profile picture path

    $table->string('status')->default('Pending');

    // Session & timestamps
    $table->rememberToken();
    $table->timestamps();
});


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
