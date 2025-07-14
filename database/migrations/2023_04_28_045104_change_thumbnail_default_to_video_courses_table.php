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
        Schema::table('video_courses', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_courses', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->default('thumbnails/default_thumbnail.png')->change();
        });
    }
};
