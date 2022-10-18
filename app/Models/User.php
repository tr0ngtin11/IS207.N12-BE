<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
     use HasApiTokens, HasFactory, Notifiable;
     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
      protected $table = 'nguoi_dungs';
      protected $fillable = [
          'name',
          'email',
          'password',
        ];
        
       
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
   
}

// <?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         //ID, Hoten, Email, Password, Role, NgDK, SDT, NgSinh, GioiTinh, urlAvt
//         Schema::create('NguoiDung', function (Blueprint $table) {
            // $table->id();
            // $table->string('Hoten');
            // $table->string('Email')->unique();
            // $table->string('Password');
            // $table->string('Role');
            // $table->dateTime('NgDK');
            // $table->string('SDT');
            // $table->dateTime('NgSinh');
            // $table->boolean('GioiTinh');
            // $table->string('UrlAvt');
            // $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('NguoiDung');
//     }
// };

