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
            $table->foreignId('parent_id')->nullable()->after('company_name')->constrained('master_department')->nullOnDelete();
            $table->string('color', 32)->nullable()->after('parent_id');
        });
    }

    public function down(): void
    {
        Schema::table('master_department', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_id');
            $table->dropColumn('color');
        });
    }
};
