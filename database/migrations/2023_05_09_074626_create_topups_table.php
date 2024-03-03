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
        Schema::create('topups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('top_phone_number')->nullable();
            $table->string('top_ntw_name')->nullable();
            $table->unsignedInteger('top_pac_id')->nullable();
            $table->string('top_profit')->nullable();
            $table->decimal('top_amount', 5, 2)->nullable();
            $table->text('top_currency')->nullable();
            $table->decimal('top_rate', 8, 2);
            $table->boolean('top_status')->default(true);
            $table->string('top_ussd_output');
            $table->tinyInteger('payment_status');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topups');
    }
};
