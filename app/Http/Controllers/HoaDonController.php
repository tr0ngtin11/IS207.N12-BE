<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHD;
use App\Models\ChiTietSP;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\DatHang;

class HoaDonController extends Controller
{
    // use HttpResponses;



    public function GetHoaDon($id)
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
}
