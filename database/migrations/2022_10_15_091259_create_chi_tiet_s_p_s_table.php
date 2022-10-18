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
        Schema::create('chitietsp', function (Blueprint $table) {
            $table->id('MaSP');
            $table->string('TenSP');
            $table->double('Gia');
            $table->enum('Size',['S', 'M', 'L','XL'])->nullable();
            $table->string('MaKM')->nullable();
            $table->timestamps();

            $table->foreign('MaSP')->references('MaSP')->on('sanpham')
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
        Schema::dropIfExists('chitietsp');
    }
};
