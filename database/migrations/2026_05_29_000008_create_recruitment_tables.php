<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitment_job_position', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('manager_id')->nullable()->constrained('user')->nullOnDelete();
            $table->foreignId('master_department_id')->nullable()->constrained('master_department')->nullOnDelete();
            $table->string('company_name')->nullable();
            $table->unsignedInteger('new_applications_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('recruitment_applicant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruitment_job_position_id')->nullable()->constrained('recruitment_job_position')->nullOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('status', 64)->default('new');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('recruitment_candidate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruitment_job_position_id')->nullable()->constrained('recruitment_job_position')->nullOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('stage', 64)->default('screening');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_candidate');
        Schema::dropIfExists('recruitment_applicant');
        Schema::dropIfExists('recruitment_job_position');
    }
};
