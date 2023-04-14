<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Controller extends BaseController
{
    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], ResponseAlias::HTTP_OK);
    }
}
