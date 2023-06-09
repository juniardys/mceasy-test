<?php

namespace App\Traits;

trait JsonResponse {
    public function responseSuccess($data, $message = '')
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ]);
    }

    public function responseError($message, $status = 401)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ]);
    }
}
