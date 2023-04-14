<?php
declare(strict_types=1);

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CompanyResource
 * @package App\Http\Resources\Company
 */
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
