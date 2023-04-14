<?php
declare(strict_types=1);

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * Class CompanyResource
 * @package App\Http\Resources\Company
 */
#[OA\Schema(
    properties: [
        new OA\Property('first_name', type: 'string'),
        new OA\Property('last_name', type: 'string'),
        new OA\Property('email', type: 'string'),
    ]
)]
class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|\Illuminate\Contracts\Support\Arrayable
    {
        return [
            'title' => $this->resource->title,
            'phone' => $this->resource->phone,
            'description' => $this->resource->description,
        ];
    }
}
