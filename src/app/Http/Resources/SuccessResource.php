<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class SuccessResource
 * @package App\Http\Resources
 */
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
