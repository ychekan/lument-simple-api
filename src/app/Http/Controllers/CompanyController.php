<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Company\CreateRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\User\UserWithTokenResource;
use App\Services\Company\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class CompanyController
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{
    /**
     * @var CompanyService $companyService
     */
    protected CompanyService $companyService;

    /**
     * Create a new controller instance.
     *
     * @param CompanyService $companyService
     * @return void
     */
    public function __construct(CompanyService $companyService)
    {
        // TODO Maybe policy
        $this->companyService = $companyService;
    }

    /**
     * Login user.
     *
     * @param CreateRequest $request
     * @return UserWithTokenResource|JsonResponse
     */
    public function create(
        CreateRequest $request
    ): CompanyResource|JsonResponse
    {
        return new CompanyResource(
            $this->companyService->create($request)
        );
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CompanyResource::collection(
            $this->companyService->getAll()
        );
    }
}
