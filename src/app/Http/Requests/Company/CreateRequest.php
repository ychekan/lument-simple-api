<?php
declare(strict_types=1);

namespace App\Http\Requests\Company;

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
        new OA\Property('title', description: 'Company title', type: 'string', maxLength: 50, minLength: 2),
        new OA\Property('phone', description: 'Company phone', type: 'string', maxLength: 12, minLength: 2),
        new OA\Property('description', description: 'Company description', type: 'string', maxLength: 255),
    ]
)]
class CreateRequest extends RequestAbstract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:50'],
            'phone' => ['string', 'max:12'],
            'description' => ['string', 'max:255'],
        ];
    }
}
