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

            // 🔹 Reference to the user who created the proposal
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade'); // Delete proposals if user is deleted

            // ===== Basic details (from form) =====
            $table->string('title');
            $table->enum('classification', ['Project', 'Program']);
            $table->text('team_members')->nullable();
            $table->string('target_agenda')->nullable();
            $table->string('location')->nullable();
            $table->string('time_frame')->nullable();

            // Beneficiaries
            $table->string('beneficiaries_who')->nullable();
            $table->integer('beneficiaries_how_many')->nullable();

            // Budget
            $table->decimal('budget_ps', 12, 2)->nullable();
            $table->decimal('budget_mooe', 12, 2)->nullable();
            $table->decimal('budget_co', 12, 2)->nullable();

            // Partner
            $table->string('partner')->nullable();

            // ===== Additional columns =====
            $table->string('leader')->nullable();
            $table->string('college_campus')->nullable();

            // Milestones
            $table->boolean('in_house')->default(false);
            $table->boolean('revised_proposal')->default(false);
            $table->boolean('ntp')->default(false);
            $table->boolean('endorsement')->default(false);
            $table->boolean('proposal_presentation')->default(false);
            $table->boolean('proposal_documents')->default(false);
            $table->boolean('program_proposal')->default(false);
            $table->boolean('project_proposal')->default(false);
            $table->boolean('moa_mou')->default(false);
            $table->boolean('activity_design')->default(false);
            $table->boolean('certificate_of_appearance')->default(false);
            $table->boolean('attendance_sheet')->default(false);
            $table->boolean('photos')->default(false);
            $table->boolean('terminal_report')->default(false);

            // Finance/display fields
            $table->string('source_of_funds')->nullable();
            $table->decimal('expenditure', 12, 2)->nullable();
            $table->string('fund_utilization_rate')->nullable();

            // Status & docs
            $table->enum('status', ['Pending','Approved','Ongoing', 'Completed', 'Cancelled'])->default('Pending');
            $table->string('approved_by')->nullable();
            $table->date('approved_at')->nullable();
            $table->string('documentation_report')->nullable();
            $table->string('code')->nullable();
            $table->text('remarks')->nullable();
            $table->string('drive_link')->nullable();

            $table->timestamps();

            // Helpful indexes
            $table->index(['classification']);
            $table->index(['status']);
            $table->index(['college_campus']);
            $table->index(['location']);
            $table->index(['code']);
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
