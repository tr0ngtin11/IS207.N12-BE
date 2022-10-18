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
        Schema::create('hoadon', function (Blueprint $table) {
            $table->id('MaHD');
           $table->bigInteger('MaNV')->unsigned();
           $table->bigInteger('MaKH')->unsigned();
           $table->bigInteger('MaCH')->unsigned();
            $table->dateTime('NgayHD');
            $table->double('TongTien');
            $table->timestamps();

            $table->foreign('MaNV')->references('MaSP')->on('sanpham')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('MaKH')->references('MaKH')->on('khachhang')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            // $table->foreign('MaCH')->references('MaCH')->on('cuahang')
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoadon');
    }
};
