<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class SuccessResource
 * @package App\Http\Resources
 */
#[OA\Schema(
    properties: [
        new OA\Property('success', type: 'boolean'),
        new OA\Property('message', type: 'string'),
        new OA\Property('code', type: 'integer'),
    ]
)]
class SuccessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable
    {
        return [
            "success" => true,
            "message" => "Success",
            "code" => ResponseAlias::HTTP_OK,
        ];
    }
}
