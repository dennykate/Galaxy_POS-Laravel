<?php

namespace App\Http\Resources\User;

use App\Http\Controllers\HelperController;
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
            "id" => encrypt($this->id),
            "profile" => $this->profile,
            "name" => $this->name,
            "phone" => $this->phone,
            "salary" => $this->salary,
            "role" => $this->role,
            "position" => $this->position,
            "profile" => HelperController::parseReturnImage($this->profile),
        ];
    }
}
