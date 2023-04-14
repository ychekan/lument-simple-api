<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Rules\EmailVerifiedAtRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use OpenApi\Attributes as OA;
use Pearl\RequestValidate\RequestAbstract;

/**
 * Class RecoverPasswordRequest
 * @package App\Http\Requests\Auth
 */
#[OA\Schema(
    required: ['token', 'password'],
    properties: [
        new OA\Property('token', description: 'Token', type: 'string', maxLength: 100),
        new OA\Property('email', description: 'User email', type: 'string', maxLength: 100),
        new OA\Property('password', description: 'User password', type: 'string', maxLength: 50),
        new OA\Property('password_confirmation', description: 'User password confirmation', type: 'string', maxLength: 50),
    ]
)]
class RecoverPasswordRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'token' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email')->withoutTrashed(),
                new EmailVerifiedAtRule(),
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                'max:50',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
        ];
    }
}
