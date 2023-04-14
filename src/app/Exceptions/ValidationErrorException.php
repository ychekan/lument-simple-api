<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use OpenApi\Attributes as OA;

/**
 * Class ValidationErrorException
 * @package App\Exceptions
 */
#[OA\Schema(
    properties: [
        new OA\Property('success', type: 'bool', default: false),
        new OA\Property('message', type: 'string', default: 'Validation Error!'),
        new OA\Property('code', type: 'integer', default: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY),
    ]
)]
class ValidationErrorException extends Exception
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @param string $message
     */
    public function __construct(string $message = 'Error') {
        parent::__construct();
        $this->message = $message;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->message ?: 'Validation Error!',
            'code' => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
        ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }
}
