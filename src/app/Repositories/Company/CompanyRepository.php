<?php
declare(strict_types=1);

namespace App\Repositories\Company;

use App\Models\Company;
use App\Models\User;
use App\Repositories\AppRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class CompanyRepository
 * @package App\Repositories\Company
 */
class CompanyRepository extends AppRepository implements CompanyRepositoryInterface
{
    /**
     * @var Company $company
     */
    protected Company $company;

    /**
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        parent::__construct();
        $this->company = $company;
    }

    /**
     * @param User $user
     * @param array $data
     * @return Company
     */
    public function save(User $user, array $data): Company
    {
        $company = $this->company->create($data);

        $user
            ->companies()
            ->attach($company);
        return $company->refresh();
    }
}
