<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('position');
            $table->unsignedBigInteger('classroom_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('classroom_id')->references('id')->on('classrooms');
        });
    }

    public function down()
    {
        Schema::dropIfExists('modules');
    }
};
