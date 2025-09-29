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
        Schema::connection('mms')->create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membership_id');
            $table->string('document_number', 50);
            $table->decimal('amount', 10, 2);
            $table->dateTime('payment_date');
            $table->enum('payment_method', ['CASH', 'TRANSFER'])->default('CASH');
            $table->string('proof_of_payment', 255)->default('');
            $table->unsignedBigInteger('created_by');
            $table->dateTime('created_at');
            $table->unsignedBigInteger('updated_by');
            $table->dateTime('updated_at');

            $table->unique(['document_number'], 'payments_1_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mms')->dropIfExists('payments');
    }
};
