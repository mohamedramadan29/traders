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
        Schema::create('add_balance_to_investment_blans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->references('id')->on('currency_plans')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_balance_to_investment_blans');
    }
};
