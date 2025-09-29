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
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->string('section', 50);
            $table->string('name', 100);
            $table->string('format', 255);
            $table->integer('counter');
            $table->string('last_counter', 255);
            $table->unsignedBigInteger('created_by');
            $table->dateTime('created_at');
            $table->unsignedBigInteger('updated_by');
            $table->dateTime('updated_at');
            $table->unique(['section', 'name', 'format'], 'counters_1_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counters');
    }
};
