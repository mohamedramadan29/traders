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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('received_user_id')->nullable();
            $table->double('currency_rate',8,2);
            $table->double('enter_currency_rate',8,2);
            $table->double('selling_currency_rate',8,2);
            $table->double('currency_amount',8,2);
            $table->tinyInteger('status')->default(0);
            $table->string('type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
