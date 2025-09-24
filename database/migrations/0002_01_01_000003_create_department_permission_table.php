<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('department_permission', function (Blueprint $table) {
            $table->uuid('department_id');
            $table->uuid('permission_id');

            $table->primary(['department_id','permission_id']);

            $table->foreign('department_id')
                  ->references('id')->on('departments')
                  ->cascadeOnDelete();

            $table->foreign('permission_id')
                  ->references('id')->on('permissions')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('department_permission');
    }
};
