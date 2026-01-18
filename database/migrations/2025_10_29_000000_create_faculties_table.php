<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();

            // Label / grouping
            $table->string('campus_college'); // e.g., CCMADI, CAS, etc.

            // Headcount (named distinctly to avoid confusion with table name)
            $table->unsignedInteger('num_faculties')->default(0);

            // Involved in Extension (60% - 173)
            $table->unsignedInteger('involved_extension_total')->default(0);
            $table->unsignedInteger('involved_extension_q1')->default(0);
            $table->unsignedInteger('involved_extension_q2')->default(0);
            $table->unsignedInteger('involved_extension_q3')->default(0);
            $table->unsignedInteger('involved_extension_q4')->default(0);

            // IEC Materials Developed (25)
            $table->unsignedInteger('iec_developed_total')->default(0);
            $table->unsignedInteger('iec_developed_q1')->default(0);
            $table->unsignedInteger('iec_developed_q2')->default(0);
            $table->unsignedInteger('iec_developed_q3')->default(0);
            $table->unsignedInteger('iec_developed_q4')->default(0);

            // IEC Materials Reproduced (600)
            $table->unsignedInteger('iec_reproduced_total')->default(0);
            $table->unsignedInteger('iec_reproduced_q1')->default(0);
            $table->unsignedInteger('iec_reproduced_q2')->default(0);
            $table->unsignedInteger('iec_reproduced_q3')->default(0);
            $table->unsignedInteger('iec_reproduced_q4')->default(0);

            // IEC Materials Distributed (600)
            $table->unsignedInteger('iec_distributed_total')->default(0);
            $table->unsignedInteger('iec_distributed_q1')->default(0);
            $table->unsignedInteger('iec_distributed_q2')->default(0);
            $table->unsignedInteger('iec_distributed_q3')->default(0);
            $table->unsignedInteger('iec_distributed_q4')->default(0);

            // Quality Extension Proposals Approved (13)
            $table->unsignedInteger('proposals_approved_total')->default(0);
            $table->unsignedInteger('proposals_approved_q1')->default(0);
            $table->unsignedInteger('proposals_approved_q2')->default(0);
            $table->unsignedInteger('proposals_approved_q3')->default(0);
            $table->unsignedInteger('proposals_approved_q4')->default(0);

            // Quality Extension Proposals Implemented (13)
            $table->unsignedInteger('proposals_implemented_total')->default(0);
            $table->unsignedInteger('proposals_implemented_q1')->default(0);
            $table->unsignedInteger('proposals_implemented_q2')->default(0);
            $table->unsignedInteger('proposals_implemented_q3')->default(0);
            $table->unsignedInteger('proposals_implemented_q4')->default(0);

            // Quality Extension Proposals Documented (13)
            $table->unsignedInteger('proposals_documented_total')->default(0);
            $table->unsignedInteger('proposals_documented_q1')->default(0);
            $table->unsignedInteger('proposals_documented_q2')->default(0);
            $table->unsignedInteger('proposals_documented_q3')->default(0);
            $table->unsignedInteger('proposals_documented_q4')->default(0);

            // Community Population Served (5,939)
            $table->unsignedInteger('community_served_total')->default(0);
            $table->unsignedInteger('community_served_q1')->default(0);
            $table->unsignedInteger('community_served_q2')->default(0);
            $table->unsignedInteger('community_served_q3')->default(0);
            $table->unsignedInteger('community_served_q4')->default(0);

            // Beneficiaries of Technical Assistance (813)
            $table->unsignedInteger('beneficiaries_assistance_total')->default(0);
            $table->unsignedInteger('beneficiaries_assistance_q1')->default(0);
            $table->unsignedInteger('beneficiaries_assistance_q2')->default(0);
            $table->unsignedInteger('beneficiaries_assistance_q3')->default(0);
            $table->unsignedInteger('beneficiaries_assistance_q4')->default(0);

            // MOA/MOU Signed (8)
            $table->unsignedInteger('moa_mou_total')->default(0);
            $table->unsignedInteger('moa_mou_q1')->default(0);
            $table->unsignedInteger('moa_mou_q2')->default(0);
            $table->unsignedInteger('moa_mou_q3')->default(0);
            $table->unsignedInteger('moa_mou_q4')->default(0);

            $table->timestamps();
            $table->unique('campus_college');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
