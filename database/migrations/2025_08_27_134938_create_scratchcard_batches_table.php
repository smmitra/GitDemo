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
        Schema::create('scratchcard_batches', function (Blueprint $table) {
            $table->id(); // id
            $table->string('batch_no')->unique(); // batch_no
            $table->integer('price'); // price
            $table->integer('quantity'); // quantity
            $table->date('disbursed_at'); // disbursed_at
            $table->integer('used_count')->default(0); // used_count
            $table->integer('remaining_count'); // remaining_count
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scratchcard_batches');
    }
};
