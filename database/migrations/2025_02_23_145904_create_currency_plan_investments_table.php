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
        Schema::create('currency_plan_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_plan')->nullable()->references('id')->on('currency_plans')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->double('total_investment',8,2);
            $table->double('currency_number',10,6);
            $table->double('currency_price',10,6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_plan_investments');
    }
};
