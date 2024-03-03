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
        Schema::create('packages_comission_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pck_com_list_id');
            $table->integer('user_com_list_id');
            $table->string('com_input_type');
            $table->dateTime('calendar_date');
            $table->string('ntw_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages_comission_rates');
    }
};
