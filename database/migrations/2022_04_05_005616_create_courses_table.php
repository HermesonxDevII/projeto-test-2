<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->string('embed_code')->nullable();
            $table->integer('type')->default(1);
            $table->time('start')->nullable();
            $table->time('end')->nullable();
            $table->string('description', 950)->nullable();
                // ->default('Sem descrição');
            $table->unsignedBigInteger('module_id')->nullable();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('classroom_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('teacher_id')->references('id')->on('users');
            $table->foreign('classroom_id')->references('id')->on('classrooms');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
