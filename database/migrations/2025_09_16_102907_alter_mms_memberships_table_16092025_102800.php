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
            $table->unsignedBigInteger('trainer_id')->nullable()->after('package_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mms')->table('memberships', function (Blueprint $table) {
            $table->dropColumn('trainer_id');
        });
    }
};
