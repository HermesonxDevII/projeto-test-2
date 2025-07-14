<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->unsignedBigInteger('evaluation_model_id')->nullable()->change();

            $table->dropForeign(['evaluation_model_id']);

            $table->foreign('evaluation_model_id')
                ->references('id')
                ->on('evaluation_models')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropForeign(['evaluation_model_id']);

            $table->unsignedBigInteger('evaluation_model_id')->change();

            $table->foreign('evaluation_model_id')
                ->references('id')
                ->on('evaluation_models')
                ->onDelete('restrict');
        });
    }
};
