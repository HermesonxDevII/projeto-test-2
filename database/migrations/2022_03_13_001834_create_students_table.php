<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->unsignedBigInteger('guardian_id');
            $table->string('email');
            $table->unsignedBigInteger('domain_language_id');
            $table->unsignedBigInteger('school_id')->nullable();
            $table->integer('avatar_id')->default(1);
            $table->boolean('status')->nullable()->default(true);
            $table->boolean('send_email')->nullable();
            $table->string('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('guardian_id')->references('id')->on('users');
            $table->foreign('domain_language_id')->references('id')->on('languages');
            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
