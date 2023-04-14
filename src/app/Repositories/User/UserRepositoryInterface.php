<?php
declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;

/**
 * Interface UserRepository
 * @package App\Repositories\User
 */
interface UserRepositoryInterface
{
    /**
     * @param string $email
     * @return User
     */
    public function getByEmail(string $email): User;

    /**
     * @param int $id
     * @return User
     */
    public function getById(int $id): User;

    /**
     * @param array $data
     * @return User
     */
    public function register(array $data): User;

    public function resetPassword(User $user, string $password): bool;
}
