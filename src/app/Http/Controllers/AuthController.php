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
    public function profile(): UserResource
    {
        return new UserResource(auth()->user());
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return SuccessResource
     * @throws ValidationErrorException
     */
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
    public function recoverPassword(RecoverPasswordRequest $request): SuccessResource
    {
        if ($this->userService->recoverPassword($request)) {
            return new SuccessResource(null);
        }
        throw new ValidationErrorException('The provided credentials do not match our records.');
    }
}
