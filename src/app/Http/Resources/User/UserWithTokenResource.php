<?php
declare(strict_types=1);

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

/**
 * Class UserWithTokenResource
 * @package App\Http\Responses\User
 */
#[OA\Schema(
    properties: [
        new OA\Property(
            'user',
            ref: '#/components/schemas/UserResource'
        ),
        new OA\Property('access_token', type: 'string'),
        new OA\Property('token_type', type: 'string'),
        new OA\Property('expires_in', type: 'integer'),
    ]
)]
class UserWithTokenResource extends JsonResource
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
            'user' => new UserResource($this->resource['user']),
            'access_token' => $this->resource['token'],
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }
}
