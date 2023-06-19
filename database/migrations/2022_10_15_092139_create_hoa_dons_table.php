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
        Schema::create('hoa_dons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('MaNV')->unsigned();
            $table->bigInteger('MaKH')->unsigned();
            $table->bigInteger('MaCH')->unsigned();
            $table->bigInteger('MaKM')->unsigned();
            $table->dateTime('NgayHD');
            $table->double('TongTien');
            $table->timestamps();

            // $table->foreign('MaNV')->references('id')->on('san_phams')
            // ->onUpdate('cascade')
            // ->onDelete('cascade');

            // $table->foreign('MaKH')->references('id')->on('khach_hangs')
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
            // $table->foreign('MaCH')->references('id')->on('cua_hangs')
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
            // $table->foreign('MaKM')->references('id')->on('khuyen_mais')
            // ->onUpdate('cascade')
            // ->onDelete('cascade'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoa_dons');
    }
};
