<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class NguoiDungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('a');
        return response()->json([
            "status" => true,
            // "sanpham" => NguoiDung::all(),
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NguoiDung  $nguoiDung
     * @return \Illuminate\Http\Response
     */
    public function show(NguoiDung $nguoiDung)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NguoiDung  $nguoiDung
     * @return \Illuminate\Http\Response
     */
    public function edit(NguoiDung $nguoiDung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NguoiDung  $nguoiDung
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NguoiDung $nguoidung)
    {
        try {
            $nguoidung->update($request->all());
            return response()->json([
                'status' => true,
                'message' => "Sửa thông tin thành công",
                'user' => $nguoidung
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
     * @param  \App\Models\NguoiDung  $nguoiDung
     * @return \Illuminate\Http\Response
     */
    public function destroy(NguoiDung $nguoiDung)
    {
        //
    }


    public function changePassword(Request $request)
    {
        //get password from database and compare with request

        if (!Auth::attempt($request->only(['password']))) {
            return $this->error('', 'Mật khẩu không chính xác', 401);
        }

        $user = NguoiDung::where('email', $request->email)->first();
        $user->password = hash::make($request->newPassword);
        $user->save();
        return  response()->json([
            'status' => true,
            'message' => "Đổi mật khẩu thành công",
            "user" =>  hash::needsRehash($user->password),
        ]);
    }
}
