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
        Schema::table('video_course_classes', function (Blueprint $table) {
            $table->string('furigana_title')->nullable()->change();
            $table->string('translated_title')->nullable()->change();
            $table->string('link')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_course_classes', function (Blueprint $table) {
            $table->string('furigana_title')->nullable(false)->change();
            $table->string('translated_title')->nullable(false)->change();
            $table->string('link')->nullable(false)->change();
            $table->string('description', 950)->nullable()->change();
        });
    }
};
