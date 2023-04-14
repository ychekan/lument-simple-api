<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Rules\EmailVerifiedAtRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Pearl\RequestValidate\RequestAbstract;

/**
 * Class LoginRequest
 * @package App\Http\Requests\Auth
 */
class LoginRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email')->withoutTrashed(),
                new EmailVerifiedAtRule(),
            ],
            'password' => [
                'required',
                'max:50',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ];
    }
}
