<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mms')->table('memberships', function (Blueprint $table) {
            $table->dropUnique('memberships_1_unique');
            // $table->unique(['user_id', 'package_id', 'start_date', 'is_active'], 'memberships_1_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mms')->table('memberships', function (Blueprint $table) {
            // $table->dropUnique('memberships_1_unique');
            $table->unique(['user_id', 'package_id', 'start_date'], 'memberships_1_unique');
        });
    }
};
