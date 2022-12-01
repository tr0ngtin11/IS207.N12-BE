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
            $table->bigIncrements('id');
            $table->bigInteger('MaHD')->unsigned();
            $table->bigInteger('MaSP')->unsigned();
            $table->integer('SoLuong');
            $table->enum('Size', ['M', 'L']);
            $table->double('Gia');
            $table->double('ThanhTien');
            $table->text('Topping')->nullable();
            $table->timestamps();


            $table->foreign('MaHD')->references('id')->on('hoa_dons')
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
