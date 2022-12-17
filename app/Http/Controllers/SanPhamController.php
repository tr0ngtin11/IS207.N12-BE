<?php

namespace App\Http\Controllers;

use App\Models\ChiTietSP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sanphamList = ChiTietSP::paginate(10);
        $sanpham_admin = ChiTietSP::all();

        return response()->json([
            "status" => true,
            "sanpham" => $sanphamList,
            "sanpham_admin" => $sanpham_admin,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $sanpham = ChiTietSP::create($request->all());
            return response()->json([
                'status' => true,
                'sanpham' => $sanpham
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChiTietSP  $chiTietSP
     * @return \Illuminate\Http\Response
     */
    public function show(ChiTietSP $sanpham)
    {
        $sanpham = ChiTietSP::find($sanpham->id);
        try {
            return response()->json([
                'status' => true,
                'sanpham' => $sanpham
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChiTietSP  $chiTietSP
     * @return \Illuminate\Http\Response
     */
    public function edit(ChiTietSP $chiTietSP)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChiTietSP  $chiTietSP
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, ChiTietSP $sanpham)
    {
        try {
            $sanpham->update($request->all());
            return response()->json([
                'status' => true,
                'message' => "Sửa thông tin thành công",
                'sanpham' => $sanpham
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChiTietSP  $chiTietSP
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChiTietSP $sanpham)
    {
        $sanpham->delete();
        return response()->json([
            'status' => true,
            'message' => "Xóa thành công",
        ]);
    }
}
