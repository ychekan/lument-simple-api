<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class UnauthorizedException
 * @package App\Exceptions
 */
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
