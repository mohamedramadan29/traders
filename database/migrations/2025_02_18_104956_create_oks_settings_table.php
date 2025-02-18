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
        Schema::create('oks_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('oks_numbers',8,2);
            $table->double('current_price',10,4);
            $table->double('old_price',10,4)->nullable();
            $table->double('total_investment',10,4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oks_settings');
    }
};
