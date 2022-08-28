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
            $table->string("name");
            $table->string("short_name");
            $table->string("jp_name");
            $table->string("short_jp_name");
            $table->string("en_name");
            $table->string("short_en_name");
            $table->string("description");
            $table->string("short_description");
            $table->string("thumbnail");
            $table->text("images");
            $table->timestamp("published_at");
            $table->integer("flag");
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
