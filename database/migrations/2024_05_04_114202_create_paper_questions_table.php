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
            $table->string('question_title', 100)->nullable();
            $table->string('type_name', 50);
            $table->unsignedTinyInteger('sr')->default(1);
            $table->unsignedTinyInteger('frequency')->default(1);
            $table->unsignedTinyInteger('marks')->default(0);
            $table->unsignedTinyInteger('compulsory_parts')->default(0);
            $table->string('number_style', 10)->default('alpha');   //alpha, numeric, roman, urdu

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
