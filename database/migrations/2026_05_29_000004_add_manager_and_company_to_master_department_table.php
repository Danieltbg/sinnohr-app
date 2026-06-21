<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_department', function (Blueprint $table) {
            $table->foreignId('manager_id')->nullable()->after('code')->constrained('user')->nullOnDelete();
            $table->string('company_name')->nullable()->after('manager_id');
        });
    }

    public function down(): void
    {
        Schema::table('master_department', function (Blueprint $table) {
            $table->dropConstrainedForeignId('manager_id');
            $table->dropColumn('company_name');
        });
    }
};
