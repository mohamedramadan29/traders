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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('transaction_id')->unique();
            $table->integer('plan_id');
            $table->decimal('plan_price', 8, 2);
            $table->string('order_id');
            $table->string('order_description');
            $table->string('payment_status');
            $table->string('payment_id')->nullable(); // ID الدفع
            $table->decimal('original_price', 8, 2)->nullable(); // السعر الأصلي
            $table->decimal('amount_received', 8, 2)->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
