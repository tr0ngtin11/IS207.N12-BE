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
        Schema::create('gia_s_p_s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('MaSP')->unsigned();
            $table->enum('Size',['S', 'M', 'L','XL'])->nullable();
            $table->double("Gia");
            $table->integer("MaKM")->nullable();
            $table->timestamps();

            
            $table->foreign('MaSP')->references('MaSP')->on('chi_tiet_s_p_s')
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
        Schema::dropIfExists('gia_s_p_s');
    }
};
