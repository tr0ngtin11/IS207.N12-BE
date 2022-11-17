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
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('MaND')->unsigned();
            $table->string('TieuDe');
            $table->string('MoTa');
            $table->string('NoiDung');
            $table->string('UrlImage');
            $table->dateTime('NgayBlog');
            $table->timestamps();
            
            $table->foreign('MaND')->references('id')->on('nguoi_dungs')
            ->onUpdate('cascade')
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
        Schema::dropIfExists('blogs');
    }
};
