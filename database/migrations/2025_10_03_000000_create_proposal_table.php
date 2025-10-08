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

            // ===== Basic details (from form) =====
            $table->string('title');                                    // Proposal title
            $table->enum('classification', ['Project', 'Program']);     // Project or Program
            $table->text('team_members')->nullable();                   // Comma-separated names
            $table->string('target_agenda')->nullable();                // Agenda focus
            $table->string('location')->nullable();                     // Location (can be campus name)
            $table->string('time_frame')->nullable();                   // Required time frame (e.g. 1 month)

            // Beneficiaries
            $table->string('beneficiaries_who')->nullable();            // e.g. Farmers, Students
            $table->integer('beneficiaries_how_many')->nullable();

            // Budget (from form)
            $table->decimal('budget_ps',   12, 2)->nullable();          // PS budget
            $table->decimal('budget_mooe', 12, 2)->nullable();          // MOOE budget
            $table->decimal('budget_co',   12, 2)->nullable();          // CO budget
            // Note: "Approved Budget" can be computed as ps+mooe+co on the model/view side

            // Partner (from form)
            $table->string('partner')->nullable();                      // Partner org(s)

            // ===== Additional columns used by the table view =====

            // Display/roster info
            $table->string('leader')->nullable();                       // Program/Project Leader (optional)
            $table->string('college_campus')->nullable();               // Explicit College/Campus (if different from 'location')

            // Milestone/checklist flags (Yes/No columns in the table)
            $table->boolean('in_house')->default(false);
            $table->boolean('revised_proposal')->default(false);
            $table->boolean('ntp')->default(false);                     // Notice to Proceed
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

            // Finance/display fields (table columns)
            $table->string('source_of_funds')->nullable();              // e.g., External Donor, GAA, etc.
            $table->decimal('expenditure', 12, 2)->nullable();          // Amount spent so far
            $table->string('fund_utilization_rate')->nullable();        // e.g., "80%" (store as text or compute)

            // Status & docs
            $table->enum('status', ['Ongoing', 'Completed', 'Cancelled'])
                  ->default('Ongoing');
            $table->string('documentation_report')->nullable();         // e.g., "Available" or a short note
            $table->string('code')->nullable();                         // e.g., "2025-001"
            $table->text('remarks')->nullable();                        // Free-form notes/remarks
            $table->string('drive_link')->nullable();                   // URL to Drive folder/files

            // Tracking
            $table->timestamps();

            // Optional helpful indexes
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
