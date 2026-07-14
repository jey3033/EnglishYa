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
        Schema::table('transaction_headers', function (Blueprint $table) {
            $table->enum('transaction_status', ['pending - admin','pending','paid'])->default('pending - admin');
        });
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->enum('enrollment_status', ['pending','ongoing','suspended','finished'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_headers', function (Blueprint $table) {
            $table->dropColumn('transaction_status');
        });
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn('enrollment_status');
        });
    }
};
