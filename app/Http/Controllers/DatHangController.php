<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DatHang;
use App\Models\HoaDon;
use App\Trait\HttpResponses;
use Illuminate\Support\Facades\Log;

class DatHangController extends Controller
{
    use HttpResponses;



    public function GetDonHang($id)
    {
        $donhang = DatHang::where('MaKH', $id)->get();
        foreach ($donhang as $key => $value) {

            $MaHD = $value->MaHD;
            $hoadon = HoaDon::where('id', $MaHD)->first();
            $tongtien = $hoadon->TongTien;
            $value['tongtien'] = $tongtien;
            $value['ngaythanhtoan'] =  $value['created_at']->format('Y-m-d H:i:s');
        }

        return response()->json([
            'status' => true,
            'donhang' => $donhang,
        ], 200);
    }
}
