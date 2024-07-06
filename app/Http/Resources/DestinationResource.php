<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DestinationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'destination_name' => $this->name,
            // 'location' => $this->getLocation(),
            'description' => $this->description,
            'images' => $this->images,
            'status' => $this->status,
            'created_by' => new UserResource(User::find($this->created_by)),
            'updated_by' => new UserResource(User::find($this->updated_by)),
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
        ];
    }
}
