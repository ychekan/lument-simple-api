<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ValidationErrorException;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RecoverPasswordRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserWithTokenResource;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @var UserService $userService
     */
    protected UserService $userService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Login user.
     *
     * @param LoginRequest $request
     * @return UserWithTokenResource|JsonResponse
     * @throws ValidationErrorException
     */
    #[OA\Post(
        path: '/api/login',
        description: 'Login endpoints',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/LoginRequest')
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Login user',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/UserWithTokenResource')
                    )
                ]
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/ValidationErrorException')
                    )
                ]
            )
        ]
    )]
    public function signIn(
        LoginRequest $request
    ): UserWithTokenResource|JsonResponse {
        $response = $this->userService->signIn($request);
        if (!empty($response['token']) && !empty($response['user'])) {
            return new UserWithTokenResource($response);
        }
        throw new ValidationErrorException('The provided credentials do not match our records.');
    }

    /**
     * @param RegisterRequest $request
     * @return UserResource|JsonResponse
     */
    #[OA\Post(
        path: '/api/register',
        description: 'Registration endpoints',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/RegisterRequest')
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Register user',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/UserResource')
                    )
                ]
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/ValidationErrorException')
                    )
                ]
            )
        ]
    )]
    public function register(
        RegisterRequest $request,
    ): UserResource|JsonResponse {
        return new UserResource(
            $this->userService->register($request)
        );
    }

    /**
     * @return UserResource
     */
    #[OA\Get(
        path: '/api/profile',
        description: 'Get current profile',
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'User profile',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/UserResource')
                    )
                ]
            ),
        ]
    )]
    public function profile(): UserResource
    {
        return new UserResource(auth()->user());
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return SuccessResource
     * @throws ValidationErrorException
     */
    #[OA\Post(
        path: '/api/recover-password',
        description: 'Request for reset password',
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Send email for reset password',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/SuccessResource')
                    )
                ]
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/ValidationErrorException')
                    )
                ]
            )
        ]
    )]
    public function forgotPassword(ForgotPasswordRequest $request): SuccessResource
    {
        if ($this->userService->forgotPassword($request)) {
            return new SuccessResource(null);
        }
        throw new ValidationErrorException('The provided credentials do not match our records.');
    }

    /**
     * @throws ValidationErrorException
     */
    #[OA\Patch(
        path: '/api/recover-password',
        description: 'Update password',
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Password updated',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/SuccessResource')
                    )
                ]
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/ValidationErrorException')
                    )
                ]
            )
        ]
    )]
    public function recoverPassword(RecoverPasswordRequest $request): SuccessResource
    {
        if ($this->userService->recoverPassword($request)) {
            return new SuccessResource(null);
        }
        throw new ValidationErrorException('The provided credentials do not match our records.');
    }
}
