<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('weekday_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');;
            $table->foreign('weekday_id')->references('id')->on('weekdays');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
