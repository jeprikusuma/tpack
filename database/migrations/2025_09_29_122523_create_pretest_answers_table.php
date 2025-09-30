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
        Schema::create('pretest_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('pretest_attempts')->onDelete('cascade');
            $table->integer('question_number');
            $table->string('answer', 10)->nullable();
            $table->boolean('is_correct')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pretest_answers');
    }
};
