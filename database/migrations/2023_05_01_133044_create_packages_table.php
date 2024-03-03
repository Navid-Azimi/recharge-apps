<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration {

/**
* Run the migrations.
*
* @return void */

    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('pck_type', ['Voice', 'SMS', 'Data', 'Credit', 'Mixed'])->nullable();
            $table->decimal('pck_credit_amount', 8, 2)->nullable();
            $table->decimal('pck_data_amount', 8, 2)->nullable();
            $table->decimal('pck_minutes_amount', 8, 2)->nullable();
            $table->decimal('pck_sms_amount', 8, 2)->nullable();
            $table->decimal('pck_price', 8, 2);
            $table->text('pck_currency_id');
            $table->text('pck_memo')->nullable();
            $table->string('pck_country')->nullable();
            $table->string('pck_user_role')->nullable();
            $table->decimal('general_comm', 5, 2);
            $table->unsignedBigInteger('pck_user_id')->nullable();
            $table->string('pck_pin_number')->nullable();
            $table->text('pck_pin_info')->nullable();
            $table->integer('pck_ntw_id');
            $table->decimal('interior_charges')->nullable();
            $table->decimal('outdoor_charges')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}