<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 8)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('province', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('country')->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 16)->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('city', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained('province')->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 16)->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('district', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('city')->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 16)->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sub_district', function (Blueprint $table) {
            $table->id();
            $table->foreignId('district_id')->constrained('district')->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 16)->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('organization', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('organization_structure', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organization')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('organization_structure')->nullOnDelete();
            $table->string('name');
            $table->string('code', 64)->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('menu')->nullOnDelete();
            $table->string('name');
            $table->string('route')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_education_level', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_education_major', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_education_institution', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_position', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_skill', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_competency', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_location', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_branch', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained('organization')->nullOnDelete();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_department', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_division', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_grade', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_workplace', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('master_team', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('user')->nullOnDelete();
            $table->string('employee_number', 64)->nullable()->unique();
            $table->string('full_name');
            $table->date('birth_date')->nullable();
            $table->string('gender', 32)->nullable();
            $table->string('mbti', 16)->nullable();
            $table->string('phone', 32)->nullable();
            $table->date('join_date')->nullable();
            $table->foreignId('employee_type_id')->nullable()->constrained('employee_type')->nullOnDelete();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_organization', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_information_id')->constrained('employee_information')->cascadeOnDelete();
            $table->foreignId('organization_id')->constrained('organization')->cascadeOnDelete();
            $table->foreignId('organization_structure_id')->nullable()->constrained('organization_structure')->nullOnDelete();
            $table->foreignId('master_position_id')->nullable()->constrained('master_position')->nullOnDelete();
            $table->boolean('is_primary')->default(true);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('role_manager', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('role')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('user')->nullOnDelete();
            $table->foreignId('menu_id')->nullable()->constrained('menu')->nullOnDelete();
            $table->json('permissions')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('role_handover', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->constrained('user')->cascadeOnDelete();
            $table->foreignId('to_user_id')->constrained('user')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('role')->cascadeOnDelete();
            $table->string('status', 32)->default('pending');
            $table->timestamp('effective_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_information_id')->constrained('employee_information')->cascadeOnDelete();
            $table->foreignId('master_education_level_id')->nullable()->constrained('master_education_level')->nullOnDelete();
            $table->foreignId('master_education_major_id')->nullable()->constrained('master_education_major')->nullOnDelete();
            $table->foreignId('master_education_institution_id')->nullable()->constrained('master_education_institution')->nullOnDelete();
            $table->year('graduation_year')->nullable();
            $table->decimal('gpa', 4, 2)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_work_experience', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_information_id')->constrained('employee_information')->cascadeOnDelete();
            $table->string('company_name');
            $table->string('title')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_information_id')->constrained('employee_information')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_project_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_project_id')->constrained('employee_project')->cascadeOnDelete();
            $table->foreignId('employee_information_id')->constrained('employee_information')->cascadeOnDelete();
            $table->string('role', 128)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_expertise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_information_id')->constrained('employee_information')->cascadeOnDelete();
            $table->foreignId('master_skill_id')->nullable()->constrained('master_skill')->nullOnDelete();
            $table->string('type', 64)->nullable();
            $table->unsignedTinyInteger('level')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_competency', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_information_id')->constrained('employee_information')->cascadeOnDelete();
            $table->foreignId('master_competency_id')->constrained('master_competency')->cascadeOnDelete();
            $table->unsignedTinyInteger('score')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_certificate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_information_id')->constrained('employee_information')->cascadeOnDelete();
            $table->string('name');
            $table->string('issuer')->nullable();
            $table->date('issued_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->string('credential_url')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_achievement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_information_id')->constrained('employee_information')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('achieved_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_career_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_information_id')->constrained('employee_information')->cascadeOnDelete();
            $table->string('title');
            $table->foreignId('organization_id')->nullable()->constrained('organization')->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_information_id')->constrained('employee_information')->cascadeOnDelete();
            $table->foreignId('master_team_id')->constrained('master_team')->cascadeOnDelete();
            $table->date('joined_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_device_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('user')->cascadeOnDelete();
            $table->foreignId('employee_information_id')->nullable()->constrained('employee_information')->cascadeOnDelete();
            $table->string('device_identifier')->nullable();
            $table->string('fcm_token')->nullable();
            $table->json('metadata')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_device_data');
        Schema::dropIfExists('employee_team');
        Schema::dropIfExists('employee_career_history');
        Schema::dropIfExists('employee_achievement');
        Schema::dropIfExists('employee_certificate');
        Schema::dropIfExists('employee_competency');
        Schema::dropIfExists('employee_expertise');
        Schema::dropIfExists('employee_project_member');
        Schema::dropIfExists('employee_project');
        Schema::dropIfExists('employee_work_experience');
        Schema::dropIfExists('employee_education');
        Schema::dropIfExists('role_handover');
        Schema::dropIfExists('role_manager');
        Schema::dropIfExists('employee_organization');
        Schema::dropIfExists('employee_information');
        Schema::dropIfExists('master_team');
        Schema::dropIfExists('master_workplace');
        Schema::dropIfExists('master_grade');
        Schema::dropIfExists('master_division');
        Schema::dropIfExists('master_department');
        Schema::dropIfExists('master_branch');
        Schema::dropIfExists('master_location');
        Schema::dropIfExists('master_competency');
        Schema::dropIfExists('master_skill');
        Schema::dropIfExists('master_position');
        Schema::dropIfExists('master_education_institution');
        Schema::dropIfExists('master_education_major');
        Schema::dropIfExists('master_education_level');
        Schema::dropIfExists('employee_type');
        Schema::dropIfExists('menu');
        Schema::dropIfExists('role');
        Schema::dropIfExists('organization_structure');
        Schema::dropIfExists('organization');
        Schema::dropIfExists('sub_district');
        Schema::dropIfExists('district');
        Schema::dropIfExists('city');
        Schema::dropIfExists('province');
        Schema::dropIfExists('country');
    }
};
