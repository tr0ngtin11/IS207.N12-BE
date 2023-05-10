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
            $value['HinhAnh'] = $sanpham->HinhAnh;
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
            $idDatHang = $value['id'];
            $dathang1 = DatHang::where('MaHD', $idDatHang)->first();
            // $dathang = json_decode($dathang1, true, JSON_UNESCAPED_UNICODE);
            // Log::info($dathang);
            $value['TrangThai'] = $dathang1->TrangThai;
            $maKH = $value['MaKH'];
            $khuyenmai = KhuyenMai::where('id', $value['MaKM'])->first();

            $khachhang = NguoiDung::where('id', $maKH)->first();
            $value['TenKM'] = $khuyenmai->TenKM;
            $value['hoten'] = $khachhang->hoten;
            $value['sdt'] = $khachhang->sdt;
            $value['diachi'] = $khachhang->diachi;
        }
        // Log::info($hoadon1);

        return response()->json([
            'status' => true,
            'hoadon' => $hoadon1,
        ], 200);
    }
}
