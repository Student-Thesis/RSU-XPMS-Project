<?php

// database/migrations/2025_09_29_000010_create_department_permissions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('department_permissions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('department_id')->constrained()->cascadeOnDelete();
            $t->string('resource');               // e.g., 'project', 'invoice'
            $t->boolean('can_view')->default(false);
            $t->boolean('can_create')->default(false);
            $t->boolean('can_update')->default(false);
            $t->boolean('can_delete')->default(false);
            $t->timestamps();

            $t->unique(['department_id', 'resource']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('department_permissions');
    }
};
