<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('message', 350)->nullable();
            $table->unsignedBigInteger('course_id');

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_notification');
    }
};
