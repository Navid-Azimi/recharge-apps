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
        // Check if the column does not exist before adding it
        if (!Schema::hasColumn('topups', 'payment_status')) {
            Schema::table('topups', function (Blueprint $table) {
                $table->boolean('payment_status')->default(true);
                $table->decimal('top_amount', 12, 2)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topups', function (Blueprint $table) {
            //
        });
    }
};
