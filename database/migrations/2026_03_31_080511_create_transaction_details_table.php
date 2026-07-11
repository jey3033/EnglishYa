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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_header_id')->constrained('transaction_headers')->onDelete('cascade');
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->double('price_per_hour');
            $table->integer('hours')->default(1);
            $table->double('subtotal');
            $table->text('detail');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->foreignId('transaction_detail_id')->constrained('transaction_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');

        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign('transaction_detail_id');
        });
    }
};
