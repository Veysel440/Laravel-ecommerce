<?php

namespace App\Support;

final class ApiResponse
{
    public static function ok(mixed $data=null, int $code=200)
    { return response()->json(['success'=>true,'data'=>$data], $code); }

    public static function fail(string $msg, int $code=400, array $meta=[])
    { return response()->json(['success'=>false,'error'=>$msg,'meta'=>$meta], $code); }
}
