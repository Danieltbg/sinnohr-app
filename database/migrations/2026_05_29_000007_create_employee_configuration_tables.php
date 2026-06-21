<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_plan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('master_department_id')->nullable()->constrained('master_department')->nullOnDelete();
            $table->foreignId('manager_id')->nullable()->constrained('user')->nullOnDelete();
            $table->string('company_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('employee_configuration_entry', function (Blueprint $table) {
            $table->id();
            $table->string('type', 64);
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['type', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_configuration_entry');
        Schema::dropIfExists('activity_plan');
    }
};
