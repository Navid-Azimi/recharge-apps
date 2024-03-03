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
        Schema::create('payment_info', function (Blueprint $table) {
            $table->id();
            $table->string('payment_info_id');
            $table->decimal('amount', 12, 2);
            $table->string('currency');
            $table->string('payment_method_types');
            $table->string('payment_method');
            $table->string('status');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
