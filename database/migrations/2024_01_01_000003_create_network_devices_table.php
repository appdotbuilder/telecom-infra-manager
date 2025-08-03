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
        Schema::create('network_devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['ODC', 'ODP', 'closure', 'router', 'switch']);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('address')->nullable();
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->integer('port_count')->nullable();
            $table->integer('ports_used')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['latitude', 'longitude']);
            $table->index('type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('network_devices');
    }
};