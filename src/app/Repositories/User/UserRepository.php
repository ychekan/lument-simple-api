<?php
declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\AppRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class LoginRepository
 * @package App\Repositories\User
 */
class UserRepository extends AppRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected User $user;

    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    public function getByEmail(string $email): User
    {
        return $this->user->where('email', $email)->firstOrFail();
    }

    public function getById(int $id): User
    {
        return $this->user->where('id', $id)->firstOrFail();
    }

    public function register(array $data): User
    {
        return $this->user->create([
            ...$data,
            'email_verified_at' => now(), // TODO: remove this line
            'password' => Hash::make($data['password']),
        ]);
    }

    public function resetPassword(User $user, string $password): bool
    {
        $user->forceFill([
            'password' => Hash::make($password)
        ])->setRememberToken(Str::random(60));

        return $user->save();
    }
}
