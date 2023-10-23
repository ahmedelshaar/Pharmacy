<?php
function responseJson($status, $message, $data = null)
{
    $response = [
        'status' => $status,
        'message' => $message,
        'data' => $data,
//        'pagination' => $data->paging,
    ];

    return response()->json($response);
}
