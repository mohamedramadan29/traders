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
        Schema::create('currency_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->string('url');
            $table->double('curreny_number',8,2)->default(0);
            $table->double('main_investment',8,2)->default(0);
            $table->double('current_investments',8,2)->default(0)->nullable();
            $table->double('currency_main_price',10,6)->default(0);
            $table->double('currency_current_price',10,6)->default(0)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_plans');
    }
};
