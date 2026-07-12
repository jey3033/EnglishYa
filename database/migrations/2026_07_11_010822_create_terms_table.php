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
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('meeting_number');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('transaction_details', function (Blueprint $table) {
             $table->foreignId('term_id')->constrained('terms')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms');
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropForeign('terms_id');
        });
    }
};
