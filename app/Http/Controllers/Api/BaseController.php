<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{

   protected function sendResponse($response, $code = 200, $status = 'success'): JsonResponse
   {
       return response()->json(['data'=>$response,'status'=>$status,'code'=>$code]);
   }
    protected function sendError($error, $code = 500, $status = 'error'): JsonResponse
    {
        return response()->json(['error'=>$error,'status'=>$status,'code'=>$code]);
    }
}
