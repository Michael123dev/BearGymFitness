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
        Schema::connection('mms')->create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name', 100);
            $table->text('description')->default('');
            $table->decimal('price', 10, 2);
            $table->decimal('discount', 5, 2)->default(0);
            $table->integer('duration_in_days');
            $table->unsignedBigInteger('created_by');
            $table->dateTime('created_at');
            $table->unsignedBigInteger('updated_by');
            $table->dateTime('updated_at');

            $table->unique('package_name', 'packages_1_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mms')->dropIfExists('packages');
    }
};
