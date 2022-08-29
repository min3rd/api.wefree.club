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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name")->nullable();
            $table->string("short_name")->nullable();
            $table->string("jp_name")->nullable();
            $table->string("en_name")->nullable();
            $table->text("description")->nullable();
            $table->string("short_description")->nullable();
            $table->text("thumbnail")->nullable();
            $table->text("images")->nullable();
            $table->date("birthday")->nullable();
            $table->smallInteger("gender")->default(0);
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
        Schema::dropIfExists('authors');
    }
};
