<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        // 
        $customer = User::find($this->user_id);
        return [
            'id' => $this->id,
            'review' => $this->review ?? '',
            'rating' => $this->rating,
            'firstName' => $customer->first_name,
            'lastName' => $customer->last_name,
        ];
    }
}
