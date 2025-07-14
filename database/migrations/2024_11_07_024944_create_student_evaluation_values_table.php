<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentEvaluationValuesTable extends Migration
{
    public function up()
    {
        Schema::create('student_evaluation_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_evaluation_id')->constrained()->onDelete('cascade');
            $table->foreignId('evaluation_parameter_id')->constrained()->onDelete('cascade');
            $table->foreignId('evaluation_value_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_evaluation_values');
    }
}
