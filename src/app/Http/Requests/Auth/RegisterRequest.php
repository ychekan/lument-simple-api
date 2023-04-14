<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rules\Password;
use OpenApi\Attributes as OA;
use Pearl\RequestValidate\RequestAbstract;

/**
 * Class RegisterRequest
 * @package App\Http\Requests\Auth
 */
#[OA\Schema(
    required: ['first_name', 'last_name', 'email', 'password', 'password_confirmation'],
    properties: [
        new OA\Property('first_name', description: 'User first name', type: 'string', maxLength: 50),
        new OA\Property('last_name', description: 'User last name', type: 'string', maxLength: 50),
        new OA\Property('email', description: 'User email', type: 'string', maxLength: 100),
        new OA\Property('password', description: 'User password', type: 'string', maxLength: 50),
        new OA\Property('password_confirmation', description: 'User password confirmation', type: 'string', maxLength: 50),
    ]
)]
class RegisterRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:50'],
            'last_name' => ['required', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'string', 'max:100', 'unique:users,email'],
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
