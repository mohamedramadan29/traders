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
        Schema::create('public_settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_name');
            $table->string('website_desc');
            $table->string('website_logo');
            $table->double('currency_number',8,2)->default(100000);
            $table->double('total_capital',8,2)->default(100000);
            $table->double('market_price',8,2)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_settings');
    }
};
