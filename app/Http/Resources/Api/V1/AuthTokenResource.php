<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthTokenResource extends JsonResource
{
    /**
     * @param  array{token: string, token_type: string, user?: User}  $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var array{token: string, token_type: string, user?: User} $payload */
        $payload = $this->resource;

        $data = [
            'token' => $payload['token'],
            'token_type' => $payload['token_type'],
        ];

        if (isset($payload['user'])) {
            $data['user'] = UserResource::make($payload['user']);
        }

        return $data;
    }
}
