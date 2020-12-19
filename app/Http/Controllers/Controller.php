<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
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
     * @param null $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data = null, $message = '')
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];
        if($data instanceof LengthAwarePaginator){
            $response += $data->toArray();
        }elseif(method_exists($data, 'toArray')){
            $response['data'] = $data->toArray();
        }
        return response()->json($response);
    }

    /**
     * Generate a failed api response
     * @param null $data
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function failed($data = null, $message = '', $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => $data
        ], $status);
    }
}
