<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class AccessDeniedException
 * @package App\Exceptions
 */
class AccessDeniedException extends Exception
{
    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Access Denied!',
            'code' => ResponseAlias::HTTP_FORBIDDEN
        ], ResponseAlias::HTTP_FORBIDDEN);
    }
}
