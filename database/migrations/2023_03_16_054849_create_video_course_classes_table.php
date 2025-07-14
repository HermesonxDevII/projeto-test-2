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
        Schema::create('video_course_classes', function (Blueprint $table) {
            $table->id();
            $table->string('furigana_title');
            $table->string('original_title');
            $table->string('translated_title');
            $table->string('link');
            $table->time('duration')->nullable();
            $table->string('description', 950)->nullable();
            $table->integer('position');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('video_course_module_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('teacher_id')->references('id')->on('users');
            $table->foreign('video_course_module_id')->references('id')->on('video_course_modules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_course_classes');
    }
};
