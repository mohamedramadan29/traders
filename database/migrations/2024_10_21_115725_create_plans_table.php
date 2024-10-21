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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('platform_id')->references('id')->on('platforms')->cascadeOnDelete();
            $table->double('main_price','10','2');
            $table->double('current_price','10','2')->default('0')->nullable();
            $table->double('step_price','8','2')->comment('الزيادة عند شراء شخص جديد الخطة ')->default('0')->nullable();
            $table->double('return_investment','8','2');
            $table->double('daily_percentage','8','2')->default('0')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->integer('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
