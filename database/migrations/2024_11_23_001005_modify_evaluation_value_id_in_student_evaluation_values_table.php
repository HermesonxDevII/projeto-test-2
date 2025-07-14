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
        Schema::table('student_evaluation_values', function (Blueprint $table) {
            // Verifica se a foreign key existe e a remove
            $table->dropForeign('student_evaluation_values_evaluation_value_id_foreign');

            // Torna a coluna nullable
            $table->unsignedBigInteger('evaluation_value_id')->nullable()->change();

            // Adiciona novamente a foreign key
            $table->foreign('evaluation_value_id')
                  ->references('id')
                  ->on('evaluation_values')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_evaluation_values', function (Blueprint $table) {
            // Remove a foreign key
            $table->dropForeign('student_evaluation_values_evaluation_value_id_foreign');

            // Reverte a nulidade da coluna
            $table->unsignedBigInteger('evaluation_value_id')->nullable(false)->change();

            // Adiciona novamente a foreign key
            $table->foreign('evaluation_value_id')
                  ->references('id')
                  ->on('evaluation_values')
                  ->onDelete('cascade');
        });
    }
};
