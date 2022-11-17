<?php

namespace App\Trait;

trait HttpResponses {
    protected function success($data,$message = null, $code = 200) {
        return  response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ],$code);
    }
    protected function error($data,$message = null, $code) {
        return  response()->json(['status' => false,
            'message' => $message,
            'data' => $data
        ],$code);
    }
}