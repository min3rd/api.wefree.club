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
        Schema::table('animes', function (Blueprint $table) {
            //
            \Doctrine\DBAL\Types\Type::addType("timestamp", \Illuminate\Database\DBAL\TimestampType::class);
            $table->string("short_name")->nullable()->change();
            $table->string("jp_name")->nullable()->change();
            $table->string("short_jp_name")->nullable()->change();
            $table->string("en_name")->nullable()->change();
            $table->string("short_en_name")->nullable()->change();
            $table->string("description")->nullable()->change();
            $table->string("short_description")->nullable()->change();
            $table->string("thumbnail")->nullable()->change();
            $table->text("images")->nullable()->change();
            $table->timestamp("published_at")->nullable()->default(null)->change();
            $table->integer("flag")->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('animes', function (Blueprint $table) {
            //
        });
    }
};
