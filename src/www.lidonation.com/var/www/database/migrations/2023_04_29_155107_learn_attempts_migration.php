<?php

use App\Enums\LearningAttemptStatuses;
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
        Schema::create('learning_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');

            $table->foreignId('learning_module_id');
            $table->foreignId('learning_topic_id');
            $table->foreignId('learning_lesson_id');

            $table->foreignId('quiz_id');
            $table->foreignId('question_id');
            $table->foreignId('question_answer_id');
            $table->foreignId('answer_response_id');

            $table->enum('status', LearningAttemptStatuses::values());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_attempts');
    }
};
