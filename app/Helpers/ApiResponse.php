<?php

namespace App\Helpers;


class ApiResponse
{
    public static function success($data = null, string $message = 'İşlem başarılı.', int $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }

    public static function error(string $message = 'Bir hata oluştu.', int $statusCode = 500, $errors = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
            'data'    => null,
        ], $statusCode);
    }
}
