<?php

namespace App\Http\Controllers;

use App\Models\KhuyenMai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KhuyenmaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'khuyenmai' => KhuyenMai::all(),
        ], 200);
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
        $khuyenmai = Khuyenmai::create([
            'TenKM' => $request->TenKM,
            'phantramKM' => $request->phantramKM,
            'Status' => 0,
        ]);
        return response()->json([
            'status' => true,
            'khuyenmai' => $khuyenmai,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Khuyenmai  $khuyenmai
     * @return \Illuminate\Http\Response
     */
    public function show(Khuyenmai $khuyenmai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Khuyenmai  $khuyenmai
     * @return \Illuminate\Http\Response
     */
    public function edit(Khuyenmai $khuyenmai)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Khuyenmai  $khuyenmai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Khuyenmai $khuyenmai)
    {
        $id = $khuyenmai->id;

        $mangKM = Khuyenmai::all();

        foreach ($mangKM as $key => $value) {

            if ($value->id == $id) {
                $value->Status = 1;
            } else {
                $value->Status = 0;
            }
            $value->save();
            Log::info($value);
        }
        $khuyenmai = Khuyenmai::find($id);
        return response()->json([
            'status' => true,
            'khuyenmai' => $khuyenmai,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Khuyenmai  $khuyenmai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Khuyenmai $khuyenmai)
    {
        $khuyenmai->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công',
        ], 200);
    }
}
