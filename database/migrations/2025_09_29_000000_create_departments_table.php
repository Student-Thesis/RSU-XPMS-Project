<?php 

// database/migrations/2025_09_29_000000_create_departments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('departments', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique(); // e.g., "HR", "Accounting", "Dispatch"
            $t->timestamps();
        });

        // optional: add department_id to users
        Schema::table('users', function (Blueprint $t) {
            $t->foreignId('department_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->dropConstrainedForeignId('department_id');
        });
        Schema::dropIfExists('departments');
    }
};
