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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();

            // Basic details
            $table->string('title');                       // Proposal title
            $table->enum('classification', ['Project', 'Program']); // Project or Program
            $table->text('team_members')->nullable();      // Comma-separated names
            $table->string('target_agenda')->nullable();   // Agenda focus
            $table->string('location')->nullable();        // Location
            $table->string('time_frame')->nullable();      // Required time frame (e.g. 1 month)

            // Beneficiaries
            $table->string('beneficiaries_who')->nullable();   // e.g. Farmers, Students
            $table->integer('beneficiaries_how_many')->nullable();

            // Budget
            $table->decimal('budget_ps', 12, 2)->nullable();   // PS budget
            $table->decimal('budget_mooe', 12, 2)->nullable(); // MOOE budget
            $table->decimal('budget_co', 12, 2)->nullable();   // CO budget

            // Partner
            $table->string('partner')->nullable();

            // Tracking
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
