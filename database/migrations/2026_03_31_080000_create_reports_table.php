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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('meeting_number');
            $table->date('meeting_date');
            $table->text('meeting_report');
            $table->string('term');
            $table->time('time_start');
            $table->time('time_end');
            $table->foreignId('course_id')->constrained('courses');
            $table->foreignId('terms_id')->constrained('terms');
            $table->foreignId('parent_id')->constrained('users');
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('teacher_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
