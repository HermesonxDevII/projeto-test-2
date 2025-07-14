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
        Schema::create('evaluation_parameters', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->unsignedBigInteger('evaluation_model_id')->nullable();
            $table->foreign('evaluation_model_id')->references('id')->on('evaluation_models')->onDelete('cascade');

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
        Schema::dropIfExists('evaluation_parameters');
    }
};
