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
            $table->decimal('price', 17, 7)->default(0)->after('document_number');
            $table->boolean('is_special_discount')->default(false)->after('price');
            $table->decimal('discount', 17, 7)->default(0)->after('is_special_discount');
            $table->decimal('discount_price', 17, 7)->default(0)->after('discount');
            $table->renameColumn('amount', 'total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mms')->table('payments', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('is_special_discount');
            $table->dropColumn('discount');
            $table->dropColumn('discount_price');
            $table->renameColumn('total_price', 'amount');
        });
    }
};
