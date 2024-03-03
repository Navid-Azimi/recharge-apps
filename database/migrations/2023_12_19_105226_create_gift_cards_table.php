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
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 9, 2);
            $table->string('currency');
            $table->integer('discount')->nullable()->default(0);
            $table->integer('total')->nullable()->default(0);
            $table->string('value');
            $table->text('bar_code');
            $table->string('payment_method')->nullable();
            $table->set('status', ['active', 'sold', 'used'])->nullable()->default('active');
            $table->foreignId('gift_type_id')->nullable()->constrained('gift_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_cards');
    }
};
