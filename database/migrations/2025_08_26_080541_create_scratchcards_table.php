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
        Schema::create('scratchcards', function (Blueprint $table) {
        $table->id();
        $table->string('batch_no'); // example: 2025-08-B001
        $table->string('card_number')->unique();
        $table->integer('card_price'); // e.g. 5, 10, 50
        $table->boolean('is_prize_eligible')->default(false);
        $table->decimal('prize_amount', 10, 2)->nullable();
        $table->date('month'); // store month wise
        $table->timestamps();
    });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scratchcards');
    }
};
