<?php

namespace App\Controllers;

class ErrorController
{
    public static function notFound($message = 'Resourse not foubd')
    {
        http_response_code(404);

        loadView('error', [
            'status' => '404',
            'message' => $message
        ]);
    }

    public static function unauthorized($message = 'You are not authorized ti view this resources')
    {
        http_response_code(403);

        loadView('error', [
            'status' => '403',
            'message' => $message
        ]);
    }
}
