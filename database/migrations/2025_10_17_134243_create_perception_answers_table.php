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
        Schema::create('perception_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->constrained('perception_responses')->onDelete('cascade');
            $table->integer('question_number'); 
            $table->enum('answer', ['STS', 'TS', 'N', 'S', 'SS']);
            $table->integer('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perception_answers');
    }
};
