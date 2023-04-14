<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ValidationErrorException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Company\CreateRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserWithTokenResource;
use App\Services\Company\CompanyService;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

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
    #[OA\Post(
        path: '/api/companies',
        description: 'Create company',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/CreateRequest')
        ),
        tags: ['Company'],
        responses: [
            new OA\Response(
                response: '201',
                description: 'Created company',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/CompanyResource')
                    )
                ]
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/ValidationErrorException')
                    )
                ]
            )
        ]
    )]
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
    #[OA\Get(
        path: '/api/companies',
        description: 'Get my company list',
        tags: ['Company'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'My company list',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/CompanyResource')
                    )
                ]
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        return CompanyResource::collection(
            $this->companyService->getAll()
        );
    }
}
