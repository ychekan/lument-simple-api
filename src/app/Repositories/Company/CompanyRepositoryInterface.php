<?php
declare(strict_types=1);

namespace App\Repositories\Company;

use App\Models\Company;
use App\Models\User;

/**
 * Interface CompanyRepository
 * @package App\Repositories\Company
 */
interface CompanyRepositoryInterface
{
    /**
     * @param User $user
     * @param array $data
     * @return Company
     */
    public function save(User $user, array $data): Company;
}
