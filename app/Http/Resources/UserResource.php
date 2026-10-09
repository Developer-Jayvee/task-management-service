<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this?->user?->name,
            'email' => $this?->user?->email,
            'role' => $this->role->value,
            'user_id' => $this->user_id,
            'created_at' => $this?->user?->created_at,
        ];
    }
}
