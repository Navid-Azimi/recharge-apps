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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('google_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('status')->default(true);
            $table->boolean('is_auto_recharge_enabled')->default(false);
            $table->integer('recharge_amount')->default(0)->nullable();
            $table->string('user_role')->nullable();
            $table->string('user_country')->required();
            $table->string('mobile_no')->nullable();
            $table->integer('threshould_amount')->default(0)->nullable();
            $table->string('user_country_iso')->nullable();
            $table->boolean('get_updates_from_gmail')->default(false)->nullable();
            $table->boolean('final_info_req_top')->default(false)->nullable();
            $table->boolean('phone_verified')->default(false)->nullable();
            $table->string('operator_name')->nullable();
            $table->string('operator_logo')->nullable();
            $table->string('apple_id')->nullable();
            $table->integer('passport_number')->nullable();
            $table->text('business_type')->nullable();
            $table->integer('business_license_nu')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
