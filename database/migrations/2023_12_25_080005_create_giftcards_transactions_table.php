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
        Schema::create('giftcards_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('product');
            $table->string('currency');
            $table->string('country');
            $table->decimal('price', 9, 2);
            $table->decimal('commission', 5, 2)->nullable()->default(0);
            $table->integer('discount')->nullable()->default(0);
            $table->integer('total')->nullable()->default(0);
            $table->boolean('status')->default(true);
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->string('recipient_email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giftcards_transactions');
    }
};
