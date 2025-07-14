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
        Schema::table('pre_registration', function (Blueprint $table) {
            $table->string('kokugo_grade')->nullable()->change();
            $table->string('shakai_grade')->nullable()->change();
            $table->string('sansuu_grade')->nullable()->change();
            $table->string('rika_grade')->nullable()->change();
            $table->string('eigo_grade')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nullable_on_pre_registration', function (Blueprint $table) {
            $table->string('kokugo_grade')->nullable(false)->change();
            $table->string('shakai_grade')->nullable(false)->change();
            $table->string('sansuu_grade')->nullable(false)->change();
            $table->string('rika_grade')->nullable(false)->change();
            $table->string('eigo_grade')->nullable(false)->change();
        });
    }
};
