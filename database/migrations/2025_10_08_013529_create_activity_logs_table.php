<?php

// database/migrations/xxxx_xx_xx_create_activity_logs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // who DID the action
            $table->uuid('user_id')->nullable()->index();

            // who should SEE this as a notification
            $table->uuid('notifiable_user_id')->nullable()->index();

            $table->string('action');              // e.g., "Created Invoice"
            $table->string('model_type')->nullable(); // e.g., App\Models\Invoice
            $table->uuid('model_id')->nullable();
            $table->json('changes')->nullable();   // store old/new values
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            // when THIS user has read the notification
            $table->timestamp('read_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('activity_logs');
    }
};
