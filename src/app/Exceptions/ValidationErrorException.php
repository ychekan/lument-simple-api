<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class ValidationErrorException
 * @package App\Exceptions
 */
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
