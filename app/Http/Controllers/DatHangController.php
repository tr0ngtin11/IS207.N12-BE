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
    public function GetDonHangMaHD($id)
    {
        $dathang = DatHang::where('MaHD', $id)->get();
        foreach ($dathang as $key => $value) {

            $MaHD = $value->MaHD;
            $hoadon = HoaDon::where('id', $MaHD)->first();
            $tongtien = $hoadon->TongTien;
            $value['tongtien'] = $tongtien;
            $value['ngaythanhtoan'] =  $value['created_at']->format('Y-m-d H:i:s');
        }

        return response()->json([
            'status' => true,
            'donhang' => $dathang,
        ], 200);
    }


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

    public function confirmTrangThaiDonHang($id)
    {
        Log::info($id);
        $dathang = DatHang::where('id', $id)->first();
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
    public function cancelTrangThaiDonHang($id)
    {
        Log::info($id);
        $dathang = DatHang::where('MaHD', $id)->first();
        Log::info($dathang);
        if ($dathang->TrangThai == "Chưa xác nhận" || $dathang->TrangThai == "Đang giao") {
            $dathang->TrangThai = "Đã hủy";
            $dathang->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Xác nhận thành công',
        ], 200);
    }
    public function doneTrangThaiDonHang($id)
    {
        Log::info($id);
        $dathang = DatHang::where('MaHD', $id)->first();
        if ($dathang == null) {
            $dathang = DatHang::where('id', $id)->first();
        }
        Log::info($dathang);
        if ($dathang->TrangThai == "Đang giao") {
            $dathang->TrangThai = "Đã giao";
            $dathang->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Xác nhận thành công',
        ], 200);
    }
}
