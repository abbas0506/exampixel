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
        Schema::create('paper_questions', function (Blueprint $table) {
            $table->id();
            // 1:mcq, 2: short - single col, 3:double - col, 4: long - simple + statement only
            $table->unsignedTinyInteger('question_type');
            $table->string('question_title', 100)->nullable();
            $table->unsignedTinyInteger('frequency')->default(1);
            $table->unsignedTinyInteger('choices')->default(0);
            $table->unsignedTinyInteger('display_cols')->default(1);
            $table->unsignedTinyInteger('sr')->default(1);
            $table->string('number_style', 10)->default('alpha');   //alpha, numeric, roman, urdu

            // $table->boolean('is_exercise')->default(1);
            // $table->boolean('is_conceptual')->default(1);

            $table->foreignId('paper_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paper_questions');
    }
};
