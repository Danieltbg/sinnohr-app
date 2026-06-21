<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('role', function (Blueprint $table) {
            if (! Schema::hasColumn('role', 'guard_name')) {
                $table->string('guard_name', 64)->default('web')->after('slug');
            }

            if (! Schema::hasColumn('role', 'permissions_count')) {
                $table->unsignedInteger('permissions_count')->default(0)->after('guard_name');
            }

            if (! Schema::hasColumn('role', 'permissions')) {
                $table->json('permissions')->nullable()->after('permissions_count');
            }
        });

        Schema::create('settings_company', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 64)->nullable()->unique();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('settings_custom_field', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model_type', 128);
            $table->string('field_type', 64)->default('text');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings_custom_field');
        Schema::dropIfExists('settings_company');

        Schema::table('role', function (Blueprint $table) {
            $columns = ['permissions', 'permissions_count', 'guard_name'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('role', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
