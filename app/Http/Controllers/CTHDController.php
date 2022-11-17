<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHD;
use Illuminate\Http\Request;

class CTHDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $cthd = ChiTietHD::create($request->all());
            return response()->json([
                'status' => true,
                'cthd' => $cthd
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
     * @param  \App\Models\ChiTietHD  $chiTietHD
     * @return \Illuminate\Http\Response
     */
    public function show(ChiTietHD $chiTietHD)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChiTietHD  $chiTietHD
     * @return \Illuminate\Http\Response
     */
    public function edit(ChiTietHD $chiTietHD)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChiTietHD  $chiTietHD
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChiTietHD $chiTietHD)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChiTietHD  $chiTietHD
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChiTietHD $chiTietHD)
    {
        //
    }
}
