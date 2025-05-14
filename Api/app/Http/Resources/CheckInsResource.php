<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckInsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "check_in_time" => $this->check_in_time,
            "check_out_time" => $this->check_out_time,
            "check_date" => $this->check_date,
            "user" => new UserResource($this->whenLoaded("user")),
        ];
    }
}
