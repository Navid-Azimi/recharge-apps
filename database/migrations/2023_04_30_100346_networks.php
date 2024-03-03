<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->string('ntw_name');
            $table->string('ntw_country_iso', 5);
            $table->decimal('ntw_rate', 5, 2);
            $table->string('ntw_logo')->nullable();
            $table->integer('ntw_min_value')->default(0)->nullable();
            $table->integer('ntw_max_value')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('networks');
    }
};
