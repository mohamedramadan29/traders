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
        Schema::create('storage_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->decimal('amount_invested', 15, 2); // المبلغ المستثمر بالدولار
            $table->integer('interest_date');
            $table->decimal('interest_rate', 5, 2); // نسبة الفائدة
            $table->decimal('final_amount', 15, 2)->nullable(); // المبلغ النهائي بعد الفائدة
            $table->decimal('bin_amount', 15, 8); // عدد العملات المشتراة
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('status')->default('1')->comment('1 active // 0 ended');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_investments');
    }
};
