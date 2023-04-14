<?php
declare(strict_types=1);

namespace App\Services\User;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RecoverPasswordRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\AppService;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class UserService
 */
class UserService extends AppService
{
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * @param LoginRequest $request
     * @return array
     */
    public function signIn(LoginRequest $request): array
    {
        $credentials = $request->only(['email', 'password']);

        $user = $this->userRepository->getByEmail($credentials['email']);

        if (empty($user->email_verified_at)) {
            return [];
        }
        if (!$token = Auth::attempt($credentials)) {
            return [];
        }

        return ['token' => $token, 'user' => $user];
    }

    /**
     * @param RegisterRequest $request
     * @return User
     */
    public function register(RegisterRequest $request): User
    {
        $data = $request->only(['first_name', 'last_name', 'email', 'password']);

        return $this->userRepository->register($data);
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return bool
     */
    public function forgotPassword(ForgotPasswordRequest $request): bool
    {
        $credentials = $request->only(['email']);

        $user = $this->userRepository->getByEmail($credentials['email']);

        if (empty($user->email_verified_at)) {
            throw new UnauthorizedHttpException('Email not verification');
        }

        $response = Password::broker()->sendResetLink($credentials, function (User $user, $token) {
            $user->sendPasswordResetNotification($token);
        });

        return $response == Password::RESET_LINK_SENT;
    }

    /**
     * @param RecoverPasswordRequest $request
     * @return bool
     */
    public function recoverPassword(RecoverPasswordRequest $request): bool
    {
        $credentials = $request->only(['email', 'password', 'password_confirmation', 'token']);

        $status = Password::reset($credentials, function (User $user, string $password) {
                $this->userRepository->resetPassword($user, $password);
            }
        );

        return $status === Password::PASSWORD_RESET;
    }


    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(): \Illuminate\Contracts\Auth\PasswordBroker
    {
        $passwordBrokerManager = new PasswordBrokerManager(app());
        return $passwordBrokerManager->broker();
    }
}
