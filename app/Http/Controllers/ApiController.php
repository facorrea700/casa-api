<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function sendResponse($result, $message)
    {
        $response = [
            "success" => true,
            "data" => $result,
            "message" => $message
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            "success" => false,
            "error" => $error,
            "errorMessages" => $errorMessages
        ];
        return response()->json($response, $code);
    }
    public function sendErrorSaldoNotAvailable($error, $errorMessages = ["Monto invalido"], $code = 406)
    {
        $response = [
            "sucess" => false,
            "error" => $error,
            "errorMessages" => $errorMessages
        ];
    }
}
