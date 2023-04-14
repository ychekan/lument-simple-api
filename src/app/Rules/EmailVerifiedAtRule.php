<?php
declare(strict_types=1);

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class EmailVerifiedAtRule
 * @package App\Rules
 */
class EmailVerifiedAtRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return User::query()->where('email', $value)
            ->whereNotNull('email_verified_at')->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Email is not verified.';
    }
}
