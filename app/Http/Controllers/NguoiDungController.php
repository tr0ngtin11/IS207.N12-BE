<?php

namespace App\Http\Controllers;

use App\Models\Khachhang;
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
        $nguoiDung = NguoiDung::all();
        foreach ($nguoiDung as $key => $value) {
            Log::info($value->ngsinh);
            $value->ngsinh = date('d-m-Y', strtotime($value->ngsinh));
        }
        return response()->json([
            "status" => true, "nguoidung" => $nguoiDung
          
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
        $user = NguoiDung::create([
            'hoten' => $request->hoten,
            'email' => $request->email,
            'role' => $request->role,
            'password' => hash::make($request->password),
            'sdt' => $request->sdt,
            'ngsinh' => $request->ngsinh,
            'gioitinh' => $request->gioitinh,
            'diachi' => $request->diachi,
            'urlavt' => $request->urlavt,



        ]);
        $customer = Khachhang::create([
            'id' => $user->id,
        ]);
        // $factory = (new Factory)->withServiceAccount(__DIR__.'/laravel-app-bc690-firebase-adminsdk-lsrie-fd8832949b.json');
        // $firestore = $factory->createFirestore();
        // $database = $firestore->database();
        // $userRef = $database->collection('User')->newDocument();
        // $userRef->set([
        //     'name' => $request->name,
        //     'email'=> $request->email,
        //     'password'=> Hash::make($request->password)
        // ]);

        return response()->json([
            'data' => $user,
            'status' => true,
            // 'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NguoiDung  $nguoiDung
     * @return \Illuminate\Http\Response
     */
    public function show(NguoiDung $nguoidung)
    {
        $nguoidung1 = NguoiDung::find($nguoidung->id);
        $nguoidung1->ngsinh = date('Y-m-d', strtotime($nguoidung1->ngsinh));
        return response()->json([
            'status' => true,
            'user' => $nguoidung1,
        ]);
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
            // Log::info($request->all());
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
    public function destroy(NguoiDung $nguoidung)
    {
        $nguoidung->delete();
        return response()->json([
            'status' => true,
            'message' => "Xóa thành công",
        ]);
    }


    
}
