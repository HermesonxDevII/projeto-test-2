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
        Schema::create('video_courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 300);
            $table->string('thumbnail')->nullable()->default('thumbnails/default_thumbnail.png');
            $table->string('cover')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_courses');
    }
};
