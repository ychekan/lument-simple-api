<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use OpenApi\Attributes as OA;

/**
 * Class UnauthorizedException
 * @package App\Exceptions
 */
#[OA\Schema(
    properties: [
        new OA\Property('success', type: 'bool', default: false),
        new OA\Property('message', type: 'string', default: 'Unauthorized!'),
        new OA\Property('code', type: 'integer', default: ResponseAlias::HTTP_UNAUTHORIZED),
    ]
)]
class UnauthorizedException extends Exception
{
    protected $message;

    /**
     * @param string $message
     */
    public function __construct(string $message = '')
    {
        parent::__construct();
        $this->message = $message;
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->message ?: 'Unauthorized!',
            'code' => ResponseAlias::HTTP_UNAUTHORIZED
        ], ResponseAlias::HTTP_UNAUTHORIZED);
    }
}
