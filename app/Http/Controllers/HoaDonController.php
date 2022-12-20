<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHD;
use App\Models\ChiTietSP;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\DatHang;
use App\Models\KhuyenMai;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Log;

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
            $value['PhanLoai'] = $sanpham->MaPL;
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
            $khuyenmai = KhuyenMai::where('id', $value['MaKM'])->first();
        
            $khachhang = NguoiDung::where('id', $maKH)->first();
            $value['TenKM'] = $khuyenmai->TenKM;
            $value['hoten'] = $khachhang->hoten;
            $value['sdt'] = $khachhang->sdt;
            $value['diachi'] = $khachhang->diachi;
        }
        Log::info($hoadon1);

        return response()->json([
            'status' => true,
            'hoadon' => $hoadon1,
        ], 200);
    }
   
}
