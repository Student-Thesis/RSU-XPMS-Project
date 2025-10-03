<?php

// database/migrations/2025_10_03_000000_create_record_forms_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('record_forms', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key (no UUID)
            $table->string('record_code', 50);
            $table->string('title');                     // "Record Title"
            $table->string('link_url');                  // Google Doc / Sheet URL
            $table->unsignedSmallInteger('maintenance_years')->default(5);
            $table->unsignedSmallInteger('preservation_years')->default(5);
            $table->string('remarks')->nullable();       // e.g., "IN-USE"
            $table->unsignedSmallInteger('display_order')->default(0); // for the "No." column
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('record_forms');
    }
};
