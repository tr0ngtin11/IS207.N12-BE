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
            $table->enum('TrangThai',['Chuaxacnhan','Daxacnhan','Danggiao','Dagiao','Dahuy']);
            $table->string('DiaChiNH'); // dia chi nhan hang
            $table->timestamps();

            
            $table->foreign('MaHD')->references('id')->on('hoa_dons')
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
