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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
        });
        Schema::table('terms', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
        });
        Schema::table('transaction_headers', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
        });
        Schema::table('meetings', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('terms', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('transaction_headers', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
