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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->json('boundaries')->nullable();
            $table->json('design_data')->nullable();
            $table->json('rab_data')->nullable();
            $table->json('permits_data')->nullable();
            $table->enum('stage', ['data', 'design', 'rab', 'permits', 'completed'])->default('data');
            $table->boolean('data_completed')->default(false);
            $table->boolean('design_completed')->default(false);
            $table->boolean('rab_completed')->default(false);
            $table->boolean('permits_completed')->default(false);
            $table->timestamps();
            
            $table->index('code');
            $table->index('stage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};