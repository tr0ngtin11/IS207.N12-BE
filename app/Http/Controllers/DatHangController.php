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

    public function GetAllDonHang()
    {
        $donhang = DatHang::all();
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

    public function DeleteDonHang($id)
    {
        $donhang = DatHang::where('MaHD', $id)->first();
        $donhang->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công',
        ], 200);
    }

    public function confirmTrangThaiDonHang(Request $request, DatHang $dathang)
    {
        Log::info($request);
        $dathang = DatHang::where('id', $request->id)->first();
        Log::info($dathang);
        if ($dathang->TrangThai == "Chưa xác nhận") {
            $dathang->TrangThai = "Đang giao";
            $dathang->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Xác nhận thành công',
        ], 200);
    }
}
