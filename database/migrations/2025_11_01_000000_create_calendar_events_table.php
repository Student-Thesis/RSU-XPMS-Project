<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // dates used by FullCalendar
            $table->date('start_date');
            $table->date('end_date')->nullable();

            // meta
            $table->string('type')->nullable();        // Development, Meeting, etc.
            $table->string('priority')->default('Medium');
            $table->string('visibility')->default('public'); // public | private
            $table->string('color')->nullable();

            // audit
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            // if you have users table:
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};
