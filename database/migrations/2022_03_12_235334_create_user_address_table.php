<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('zip_code')->nullable(true);
            $table->string('province')->nullable(true);
            $table->string('city')->nullable(true);
            $table->string('number')->nullable(true);
            $table->string('district')->nullable(true);
            $table->string('complement')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('adresses');
    }
};
