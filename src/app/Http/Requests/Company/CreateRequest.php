<?php
declare(strict_types=1);

namespace App\Http\Requests\Company;

use Pearl\RequestValidate\RequestAbstract;

/**
 * Class RegisterRequest
 * @package App\Http\Requests\Auth
 */
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
