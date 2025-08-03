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
        Schema::create('billing_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('period_month', 7);
            $table->decimal('usage_mb', 15, 2)->nullable();
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->timestamp('due_date');
            $table->timestamp('paid_at')->nullable();
            $table->json('mikrotik_data')->nullable();
            $table->timestamps();
            
            $table->index(['customer_id', 'period_month']);
            $table->index('status');
            $table->index('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_records');
    }
};