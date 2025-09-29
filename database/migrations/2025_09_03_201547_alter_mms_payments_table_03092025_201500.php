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
        Schema::connection('mms')->table('payments', function (Blueprint $table) {
            $table->index('payment_date', 'payments_1_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mms')->table('payments', function (Blueprint $table) {
            $table->dropIndex('payments_1_index');
        });
    }
};
