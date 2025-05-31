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
        Schema::create('referal_withdraws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referal_withdraws');
    }
};
