<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChiTietHD;
use Illuminate\Http\Request;
use App\Trait\HttpResponses;
use Illuminate\Support\Facades\Log;
use App\Models\GiaSP;
use App\Models\ChiTietSP;
use App\Models\HoaDon;
use App\Models\ChiTietHoaDon;
use App\Models\PhanLoai;
use App\Models\KhuyenMai;
use PhpParser\Node\Expr\Cast\Object_;
use stdClass;

class ThanhToanController extends Controller
{
    use HttpResponses;


    public function thanhToan(Request $request)
    {
        $input = $request->all();
        $STTCTHD = HoaDon::latest('id')->first();
        Log::info($STTCTHD);
        if ($STTCTHD == null) {
            $MaHD = 1;
        } else {
            Log::info($STTCTHD);
            $MaHD = $STTCTHD->id + 1;
            Log::info($MaHD);
        }
        $hoadon = HoaDon::create([
            'id' => $MaHD,
            'NgayHD' => now(),
            'TongTien' => 0,
        ]);
        $hoadon->save();

        // foreach ($input as $key => $val) {
        //     Log::info($val);
        // }
        // Log::info($input);
        //get value object
        $tongtien = 0;
        foreach ($input as $key => $value) {
            // $array = $value;

            // Log::info($value);
            // // foreach ($array as $key => $value) {
            // Log::info($array);
            // // }

            // if (is_string($data)) {
            //     $data = json_decode($data,true);
            // }
            // // $jsonobj = '[{"MaSP":35,
            // //     "SoLuong":37,"Size":43,"MaPL":1,"MaKM":0}]';
            // $array = json_decode($data);
            // Log::info($array);


            $thanhtien = 0;

            $MaSP = $value["MaSP"];
            $SoLuong = $value["SoLuong"];
            $Size = $value["Size"];
            $MaPL = $value["MaPL"];
            $MaKM = $value["MaKM"];
            Log::info($MaSP);
            if ($Size == "S") {
                $sanpham = ChiTietSP::where('id', $MaSP)->first();

                $thanhtien = $value["SoLuong"] * $sanpham->Gia;
                Log::info($thanhtien);
                $tongtien += $thanhtien;
                $cthd = ChiTietHD::create([
                    'id' => $MaHD,
                    'MaSP' => $MaSP,
                    'SoLuong' => $SoLuong,
                    'ThanhTien' => $thanhtien,
                ]);
                $cthd->save();
            } else {
                $sanpham = GiaSP::where('MaSP', $MaSP)->where('Size', $Size)->first();

                $thanhtien = $value["SoLuong"] * $sanpham->Gia;
                Log::info($thanhtien);

                $tongtien += $thanhtien;
                $cthd = ChiTietHD::create([
                    'id' => $MaHD,
                    'MaSP' => $MaSP,
                    'SoLuong' => $SoLuong,
                    'ThanhTien' => $thanhtien,
                ]);
                $cthd->save();
            }
        }
        $hoadon->TongTien = $tongtien;
        Log::info($thanhtien);

        $hoadon->save();
        return response()->json([
            'status' => true,
            'message' => 'Thanh toán thành công',
            'tongtien' => $tongtien,
        ], 200);
    }
}
