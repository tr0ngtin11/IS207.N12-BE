<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog_array = Blog::all();
        foreach ($blog_array as $key => $value) {
            $nguoidung = NguoiDung::where('id', $value->MaND)->first();
            $value['tacgia'] = $nguoidung->hoten;
        }

        return response()->json([
            "status" => true,
            "blog" => $blog_array,
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
            $blog = Blog::create(
                [
                    'MaND' => $request->MaND,
                    'TieuDe' => $request->TieuDe,
                    'MoTa' => $request->MoTa,
                    'NoiDung' => $request->NoiDung,
                    'UrlImage' => $request->UrlImage,
                    'NgayBlog' => now(),
                ]
            );
          
            return response()->json([
                'status' => true,
                'sanpham' => $blog
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
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        $blog = Blog::find($blog->id);
        $nguoidung = NguoiDung::where('id', $blog->MaND)->first();
        $blog['tacgia'] = $nguoidung->hoten;
        return response()->json([
            'status' => true,
            'blog' => $blog
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        try {
            $blog->update($request->all());
            return response()->json([
                'status' => true,
                'message' => "Sửa thông tin thành công",
                'sanpham' => $blog
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
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response()->json([
            'status' => true,
            'message' => "Xóa thành công",
        ]);
    }
}
