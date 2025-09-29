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
            $table->index('user_id', 'memberships_1_index');
            $table->index('package_id', 'memberships_2_index');
            $table->index(['is_active', 'start_date', 'end_date'], 'memberships_3_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mms')->table('memberships', function (Blueprint $table) {
            $table->dropIndex('memberships_1_index');
            $table->dropIndex('memberships_2_index');
            $table->dropIndex('memberships_3_index');
        });
    }
};
