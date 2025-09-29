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
        Schema::connection('mms')->create('trainers', function (Blueprint $table) {
            $table->id();
            $table->string('trainer_code', '30');
            $table->string('name', 255);
            $table->date('birth_date')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->default('');
            $table->unsignedBigInteger('created_by');
            $table->dateTime('created_at');
            $table->unsignedBigInteger('updated_by');
            $table->dateTime('updated_at');

            $table->unique(['trainer_code'], 'trainers_1_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mms')->dropIfExists('trainers');
    }
};
