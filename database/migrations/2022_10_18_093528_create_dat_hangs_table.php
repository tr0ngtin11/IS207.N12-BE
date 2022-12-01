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
        Schema::create('dat_hangs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('MaHD')->unsigned();
            $table->string('HoTen');
            $table->string('SDT');
            $table->string('Email');
            $table->string('PTTT');
            $table->bigInteger('MaKH')->unsigned();
            $table->enum('TrangThai',['Chuaxacnhan','Daxacnhan','Danggiao','Dagiao','Dahuy']);
            $table->string('DiaChiNH'); // dia chi nhan hang
            $table->string('GhiChu')->nullable(); // ghichu
            $table->timestamps();

            
            $table->foreign('MaHD')->references('id')->on('hoa_dons')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('MaKH')->references('id')->on('khach_hangs')
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
        Schema::dropIfExists('dat_hangs');
    }
};
