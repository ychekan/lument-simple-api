<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Rules\EmailVerifiedAtRule;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;
use Pearl\RequestValidate\RequestAbstract;

/**
 * Class ForgotPasswordRequest
 * @package App\Http\Requests\Auth
 */
#[OA\Schema(
    required: ['email'],
    properties: [
        new OA\Property('email', description: 'User email', type: 'string', maxLength: 100),
    ]
)]
class ForgotPasswordRequest extends RequestAbstract
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
        ];
    }
}
