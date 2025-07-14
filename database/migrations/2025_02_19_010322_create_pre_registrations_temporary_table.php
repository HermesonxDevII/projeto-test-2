<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_registrations_temporary', function (Blueprint $table) {
            $table->id();
            $table->string('guardian_name');
            $table->string('guardian_email');
            $table->string('guardian_phone');
            $table->string('province');
            $table->string('student_name');
            $table->string('student_class');
            $table->string('student_language');
            $table->string('student_japan_arrival');
            $table->string('student_has_difficult');
            $table->string('student_difficult_in_class');
            $table->unsignedBigInteger('student_id')->nullable();

            $table->foreign('student_id')->references('id')->on('students');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_registrations_temporary');
    }
};
