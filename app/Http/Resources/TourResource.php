<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tour_name' => $this->name,
            'tour_description' => $this->descriptin,
            'tour_price' => $this->price,
            'duration' => $this->duration,
            'start_date' => $this->start_date->format('d-m-Y'),
            'end_date' => $this->end_date->format('d-m-Y'),
            'max_people' => $this->max_people,
            'status' => $this->status,
            'created_by' => new UserResource(User::find($this->created_by)),
            'updated_by' => new UserResource(User::find($this->updated_by)),
        ];
    }
}
