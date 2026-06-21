<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * When {@see 2026_05_12_100000_add_role_to_user_table} ran, existing rows received default role "user".
 * Fix known seeded emails so admin can access the admin panel and employee the portal.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('user', 'role')) {
            return;
        }

        DB::table('user')
            ->where('email', 'admin@example.com')
            ->update(['role' => 'admin']);

        DB::table('user')
            ->where('email', 'employee@example.com')
            ->update(['role' => 'user']);
    }

    public function down(): void
    {
        // Intentionally empty: reverting would break panel access again for seeded accounts.
    }
};
