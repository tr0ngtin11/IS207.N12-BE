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
        Schema::create('cuahang', function (Blueprint $table) {
            $table->id('MaCh');
            $table->bigInteger('MaQL')->unsigned();
            $table->string('TenCH');
            $table->string('SDT');
            $table->string('DiaChi');
            $table->timestamps();


            $table->foreign('MaQL')->references('MaQL')->on('quanli')
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
        Schema::dropIfExists('cuahang');
    }
};
