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
        Schema::create('userstoragedailyinvestments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('sotrage_plan')->references('id')->on('storageplans')->cascadeOnDelete();
            $table->integer('storage_days');
            $table->integer('investment_id');
            $table->double('profit_percentage',10,2);
            $table->double('amount_return',10,2);
            $table->date('return_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userstoragedailyinvestments');
    }
};
