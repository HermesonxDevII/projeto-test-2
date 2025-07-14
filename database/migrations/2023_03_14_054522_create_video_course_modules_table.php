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
        Schema::create('video_course_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('position');
            $table->unsignedBigInteger('video_course_id');           
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('video_course_id')->references('id')->on('video_courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_course_modules');
    }
};
