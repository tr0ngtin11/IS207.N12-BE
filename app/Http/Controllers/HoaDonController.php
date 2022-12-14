<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHD;
use App\Models\ChiTietSP;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\DatHang;
use App\Models\NguoiDung;

class HoaDonController extends Controller
{
    // use HttpResponses;



    public function GetCTHDHoaDon($id)
    {
        $hoadon = ChiTietHD::where('MaHD', $id)->get();
       

        foreach ($hoadon as $key => $value) {
            $MaSP = $value->MaSP;
            $sanpham = ChiTietSP::where('id', $MaSP)->first();
            $value['TenSP'] = $sanpham->TenSP;
        }
        return response()->json([
            'status' => true,
            'hoadon' => $hoadon,
        ], 200);
    }

    public function GetHoaDon()
    {
        $hoadon1 = HoaDon::all();

        foreach ($hoadon1 as $key => $value) {
            $maKH = $value['MaKH'];
            $khachhang = NguoiDung::where('id', $maKH)->first();
            $value['hoten'] = $khachhang->hoten;
            $value['sdt'] = $khachhang->sdt;
            $value['diachi'] = $khachhang->diachi;
        }


        return response()->json([
            'status' => true,
            'hoadon' => $hoadon1,
        ], 200);
    }
   
}
