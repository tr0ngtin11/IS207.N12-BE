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
        Schema::create('chi_tiet_h_d_s', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->bigInteger('MaSP')->unsigned();
            $table->integer('SoLuong');
            $table->double('ThanhTien');
            $table->timestamps();
            $table->primary(['id','MaSP']);

            
            $table->foreign('id')->references('id')->on('hoa_dons')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            // $table->foreign('MaSP')->references('id')->on('chi_tiet_s_p_s')
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
        Schema::dropIfExists('chi_tiet_h_d_s');
    }
};
