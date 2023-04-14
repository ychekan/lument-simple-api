<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use OpenApi\Attributes as OA;

/**
 * Class AccessDeniedException
 * @package App\Exceptions
 */
#[OA\Schema(
    properties: [
        new OA\Property('success', type: 'bool', default: false),
        new OA\Property('message', type: 'string', default: 'Access Denied!'),
        new OA\Property('code', type: 'integer', default: ResponseAlias::HTTP_FORBIDDEN),
    ]
)]
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
