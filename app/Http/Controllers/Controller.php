<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    /**
     * Generate a success api response
     * @param string $message
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($message = '', $data = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ]);
    }

    /**
     * Generate a failed api response
     * @param string $message
     * @param null $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function failed($message = '', $data = null, $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => $data
        ], $status);
    }
}
