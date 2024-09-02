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
            $table->foreignId('paper_id')->constrained()->cascadeOnDelete();
            $table->foreignId('type_id')->constrained()->cascadeOnDelete();
            $table->string('question_title', 100)->nullable();
            $table->string('display_style', 10)->nullable();
            $table->unsignedTinyInteger('marks')->default(1);
            $table->unsignedTinyInteger('exercise_ratio')->default(0);
            $table->unsignedTinyInteger('conceptual_ratio')->default(0);
            $table->unsignedTinyInteger('frequency')->default(1);
            $table->unsignedTinyInteger('choices')->default(0);
            $table->string('number_style', 10)->default('alpha');   //alpha, numeric, roman, urdu
            $table->unsignedTinyInteger('display_cols')->default(1);
            $table->unsignedTinyInteger('position')->default(1);

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
