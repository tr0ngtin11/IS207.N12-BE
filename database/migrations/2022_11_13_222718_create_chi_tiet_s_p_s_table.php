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
        Schema::create('chi_tiet_s_p_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('TenSP');
            $table->double('Gia');
            $table->bigInteger('MaPL')->unsigned();
            $table->string('HinhAnh');	
            $table->timestamps();

            // $table->foreign('MaPL')->references('id')->on('phan_loais')
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
        Schema::dropIfExists('chi_tiet_s_p_s');
    }
};
