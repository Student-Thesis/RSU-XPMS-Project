<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up(): void
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            
            // User relationship
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Proposal relationship (BIGINT default)
            $table->foreignId('proposal_id')
                  ->nullable()
                  ->constrained('proposals')
                  ->onDelete('set null');

            $table->string('organization_name')->nullable();
            $table->date('date_signed')->nullable();

            $table->string('mou_path')->nullable();
            $table->string('mou_link')->nullable();

            $table->string('moa_path')->nullable();
            $table->string('moa_link')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
