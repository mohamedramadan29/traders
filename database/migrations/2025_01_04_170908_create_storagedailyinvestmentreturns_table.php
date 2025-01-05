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
        Schema::create('storagedailyinvestmentreturns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sotrage_plan')->references('id')->on('storageplans')->cascadeOnDelete();
            $table->double('daily_return_percentage',10,2);
            $table->date('return_date');
            $table->double('total_dollar_amount',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storagedailyinvestmentreturns');
    }
};
