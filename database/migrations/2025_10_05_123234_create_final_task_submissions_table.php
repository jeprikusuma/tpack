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
        Schema::create('final_task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 3 tugas fix: TA1, TA2, TA3
            $table->enum('task_code', ['TA1', 'TA2', 'TA3']);

            // path file
            $table->string('file_path', 255);

            // tanggal upload
            $table->dateTime('submitted_at')->nullable();

            $table->timestamps();

            // tidak boleh ada duplikat tugas yang sama untuk satu mahasiswa
            $table->unique(['user_id', 'task_code'], 'unique_student_task');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_task_submissions');
    }
};
