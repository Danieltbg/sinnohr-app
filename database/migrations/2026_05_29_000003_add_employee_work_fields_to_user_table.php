<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('work_phone', 32)->nullable()->after('phone');
            $table->json('employee_tags')->nullable()->after('employee_badge');
            $table->string('profile_photo_path')->nullable()->after('employee_tags');
            $table->foreignId('master_department_id')->nullable()->after('profile_photo_path')->constrained('master_department')->nullOnDelete();
            $table->foreignId('master_position_id')->nullable()->after('master_department_id')->constrained('master_position')->nullOnDelete();
            $table->foreignId('manager_id')->nullable()->after('master_position_id')->constrained('user')->nullOnDelete();
            $table->foreignId('coach_id')->nullable()->after('manager_id')->constrained('user')->nullOnDelete();
            $table->string('work_address')->nullable()->after('coach_id');
            $table->string('work_location')->nullable()->after('work_address');
            $table->foreignId('time_off_approver_id')->nullable()->after('work_location')->constrained('user')->nullOnDelete();
            $table->foreignId('attendance_manager_id')->nullable()->after('time_off_approver_id')->constrained('user')->nullOnDelete();
            $table->string('working_hours')->nullable()->after('attendance_manager_id');
            $table->string('timezone', 64)->default('UTC')->after('working_hours');
            $table->string('company_name')->nullable()->after('timezone');
            $table->string('department_note')->nullable()->after('company_name');
            $table->string('private_email')->nullable()->after('department_note');
            $table->string('private_phone', 32)->nullable()->after('private_email');
            $table->text('home_address')->nullable()->after('private_phone');
            $table->date('birth_date')->nullable()->after('home_address');
            $table->string('gender', 32)->nullable()->after('birth_date');
        });
    }

    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropConstrainedForeignId('master_department_id');
            $table->dropConstrainedForeignId('master_position_id');
            $table->dropConstrainedForeignId('manager_id');
            $table->dropConstrainedForeignId('coach_id');
            $table->dropConstrainedForeignId('time_off_approver_id');
            $table->dropConstrainedForeignId('attendance_manager_id');
            $table->dropColumn([
                'work_phone',
                'employee_tags',
                'profile_photo_path',
                'work_address',
                'work_location',
                'working_hours',
                'timezone',
                'company_name',
                'department_note',
                'private_email',
                'private_phone',
                'home_address',
                'birth_date',
                'gender',
            ]);
        });
    }
};
