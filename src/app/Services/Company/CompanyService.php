<?php
declare(strict_types=1);

namespace App\Services\Company;

use App\Http\Requests\Company\CreateRequest;
use App\Models\Company;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\User\UserRepository;
use App\Services\AppService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class CompanyService
 * @package App\Services\Company
 */
class CompanyService extends AppService
{
    /**
     * @var CompanyRepository $companyRepository
     */
    protected CompanyRepository $companyRepository;

    /**
     * @var UserRepository $userRepository
     */
    protected UserRepository $userRepository;

    public function __construct(CompanyRepository $companyRepository, UserRepository $userRepository)
    {
        parent::__construct();
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        $user = $this->userRepository->getById(Auth::id());

        return $user->companies;
    }

    /**
     * @param CreateRequest $data
     * @return Company
     */
    public function create(CreateRequest $request): Company
    {
        $data = $request->only(['title', 'phone', 'description']);

        $user = $this->userRepository->getById(Auth::id());

        return $this->companyRepository->save($user, $data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Company
     */
    public function update(int $id, array $data): Company
    {
        return $this->companyRepository->update($id, $data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->companyRepository->delete($id);
    }
}
