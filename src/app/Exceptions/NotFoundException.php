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
        new OA\Property('message', type: 'string', default: 'Not Found!'),
        new OA\Property('code', type: 'integer', default: ResponseAlias::HTTP_NOT_FOUND),
    ]
)]
class NotFoundException extends Exception
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
            'message' => 'Not Found!',
            'code' => ResponseAlias::HTTP_NOT_FOUND
        ], ResponseAlias::HTTP_NOT_FOUND);
    }
}
