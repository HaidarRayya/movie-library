<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        // Count the number of reviews

        $ratings = $this->ratings()->get();
        $ratingMovie = 0;
        foreach ($ratings as $rating) {
            $ratingMovie += $rating->rating;
        }
        $numberOfRatings = count($ratings);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'director' => $this->director,
            'release_year' => $this->release_year,
            'discription' => $this->discription,
            'image' => asset('storage/' .  $this->image),
            'rating' => $numberOfRatings == 0 ? (float)0 :  (float)($ratingMovie / $numberOfRatings),
            'numberOfRatings' => $numberOfRatings
        ];
    }
}
