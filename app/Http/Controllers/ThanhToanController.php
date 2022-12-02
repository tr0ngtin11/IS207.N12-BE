<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChiTietHD;
use Illuminate\Http\Request;
use App\Trait\HttpResponses;
use Illuminate\Support\Facades\Log;
use App\Models\ChiTietSP;
use App\Models\HoaDon;
use App\Models\ChiTietHoaDon;
use App\Models\DatHang;
use App\Models\PhanLoai;
use App\Models\KhuyenMai;
use App\Models\NguoiDung;
use PhpParser\Node\Expr\Cast\Object_;
use stdClass;

class ThanhToanController extends Controller
{
    use HttpResponses;


    public function thanhToan(Request $request)
    {
        Log::info($request);
        $input = $request->all();
        // Log::info($input["list"]);
        $listOrder = $input["list"];
        // Log::info($listOrder);
        // foreach ($listOrder as $key => $value) {
        //     Log::info($value['Topping']);
        // }
        $STTCTHD = HoaDon::latest('id')->first();
        // Log::info($STTCTHD);

        if ($STTCTHD == null) {
            $MaHD = 1;
        } else {
            // Log::info($STTCTHD);
            $MaHD = $STTCTHD->id + 1;
            // Log::info($MaHD);
        }
        $hoadon = HoaDon::create([
            'id' => $MaHD,
            'MaKH' => $input["MaKH"],
            'NgayHD' => now(),
            'TongTien' => 0,
        ]);

        $tongtien = 0;
        foreach ($listOrder as $key => $value) {

            $tentoppingArray = [];
            $thanhtien = 0;
            $giatongTopping = 0;
            $topping = $value['Topping'];
            // foreach ($topping as $key => $value1) {
            //     Log::info($value1);
            // }
            $MaSP = $value["MaSP"];
            $SoLuong = $value["SoLuong"];
          
            $Size = $value["Size"];
            $MaPL = $value["MaPL"];
            $MaKM = $value["MaKM"];
            Log::info($Size);
            if ($Size == "M") {
                $sanpham = ChiTietSP::where('id', $MaSP)->first();
                if ($topping != null) {
                    foreach ($topping as $key => $mangTopping) {
                        // Log::info($mangTopping);
                        $topping = ChiTietSP::where('id', $mangTopping['MaSP'])->first();
                        $giatopping = $topping->Gia;
                        $giatongTopping += $giatopping;
                        array_push($tentoppingArray, $topping->TenSP);
                    }
                }
                $thanhtien += $value["SoLuong"] * ($sanpham->Gia + $giatongTopping);
                // Log::info($thanhtien);
                $tongtien += $thanhtien;
                $tentoppingString =  (implode(",", $tentoppingArray));
                // Log::info($tentoppingString);
                $cthd = ChiTietHD::create([
                    'MaHD' => $MaHD,
                    'MaSP' => $MaSP,
                    'SoLuong' => $SoLuong,
                    'Size' => $Size,
                    'Gia' => $thanhtien,
                    'ThanhTien' => $thanhtien,
                    'Topping' => $tentoppingString,
                ]);
                $cthd->save();
            } else if ($Size == "L") {
                $sanpham = ChiTietSP::where('id', $MaSP)->first();
                if ($topping != null) {
                    foreach ($topping as $key => $mangTopping) {
                    
                        $topping = ChiTietSP::where('id', $mangTopping['MaSP'])->first();
                        $giatopping = $topping->Gia;
                        $giatongTopping += $giatopping;
                        array_push($tentoppingArray, $topping->TenSP);
                    }
                }
                $thanhtien += $value["SoLuong"] * ($sanpham->Gia + $giatongTopping) + 5000;
                // Log::info($thanhtien);
                $tongtien += $thanhtien;
                $tentoppingString =  (implode(",", $tentoppingArray));
                // Log::info($tentoppingString);
                $cthd = ChiTietHD::create([
                    'MaHD' => $MaHD,
                    'MaSP' => $MaSP,
                    'SoLuong' => $SoLuong,
                    'Size' => $Size,
                    'Gia' => $thanhtien,
                    'ThanhTien' => $thanhtien,
                    'Topping' => $tentoppingString,
                ]);
                $cthd->save();
            } 
        }
        $hoadon->TongTien = $tongtien + 40000;

        $hoadon->save();
        $nguoidung = NguoiDung::where('id', $input["MaKH"])->first();
        $donhang = DatHang::create([
            'MaHD' => $MaHD,
            'HoTen' => $nguoidung->hoten,
            'SDT' => $nguoidung->sdt,
            'Email' => $nguoidung->email,
            'PTTT' => "COD",
            'MaKH' => $input["MaKH"],
            'TrangThai' => "Chuaxacnhan",
            'DiaChiNH' => $nguoidung->diachi,



        ]);
        $donhang->save();
        return response()->json([
            'status' => true,
            'message' => 'Thanh toán thành công',
            'donhang' => $donhang,
        ], 200);
    }
}
