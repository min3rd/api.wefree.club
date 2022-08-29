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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name")->nullable();
            $table->string("short_name")->nullable();
            $table->string("jp_name")->nullable();
            $table->string("short_jp_name")->nullable();
            $table->string("en_name")->nullable();
            $table->string("short_en_name")->nullable();
            $table->string("description")->nullable();
            $table->string("short_description")->nullable();
            $table->string("thumbnail")->nullable();
            $table->text("images")->nullable();
            $table->timestamp("published_at")->nullable();
            $table->integer("flag")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animes');
    }
};
