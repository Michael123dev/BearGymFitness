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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('section', 30);
            $table->string('label', 50);
            $table->string('reff1', 100)->default('');
            $table->string('reff2', 100)->default('');
            $table->string('reff3', 100)->default('');
            $table->string('reff4', 100)->default('');
            $table->string('reff5', 100)->default('');
            $table->text('data')->nullable()->default(null);
            $table->boolean('is_active')->default(true);
            $table->date('start_effective')->nullable();
            $table->date('end_effective')->nullable();
            $table->datetime('created_at');
            $table->datetime('updated_at');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
