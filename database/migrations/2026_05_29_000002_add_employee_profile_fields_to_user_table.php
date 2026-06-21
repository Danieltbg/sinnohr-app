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
            $table->string('job_title')->nullable()->after('email');
            $table->string('phone', 32)->nullable()->after('job_title');
            $table->string('employee_badge', 32)->default('employee')->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn(['job_title', 'phone', 'employee_badge']);
        });
    }
};
