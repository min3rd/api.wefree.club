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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name")->nullable();
            $table->text("thumbnail")->nullable();
            $table->text("images")->nullable();
            $table->text("description")->nullable();
            $table->string("short_description")->nullable();
            $table->text("drive_id")->nullable();
            $table->text("item_id")->nullable();
            $table->text("parameters")->nullable();
            $table->text("server_2")->nullable();
            $table->text("server_3")->nullable();
            $table->integer("flag")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodes');
    }
};
