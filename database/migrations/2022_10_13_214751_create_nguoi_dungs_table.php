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
        
        Schema::create('nguoi_dungs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hoten');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role',['khachhang','nhanvien','quanli']);
            $table->dateTime('ngdk')->nullable();
            $table->string('sdt')->nullable();
            $table->dateTime('ngsinh')->nullable();
            $table->boolean('gioitinh')->nullable();
            $table->string('urlavt')->nullable();
            $table->string('diachi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nguoi_dungs');
    }
};
