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
        Schema::create('platform_investment_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('platform_id')->references('id')->on('platforms')->cascadeOnDelete();
            $table->decimal('return_amount', 10, 2); // مبلغ عائد الاستثمار
            $table->timestamp('return_date'); // تاريخ توزيع العائد
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_investment_returns');
    }
};
