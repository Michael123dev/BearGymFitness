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
        Schema::table('users', function (Blueprint $table) {
            $table->index('role_id', 'users_1_index');
            $table->index('birth_date', 'users_2_index');
            $table->index('created_at', 'users_3_index');
            $table->index('gender', 'users_4_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_1_index');
            $table->dropIndex('users_2_index');
            $table->dropIndex('users_3_index');
            $table->dropIndex('users_4_index');
        });
    }
};
