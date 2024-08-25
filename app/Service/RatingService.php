<?php

namespace App\Service;

use App\Http\Resources\RatingResource;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingService
{
    /**
     * show a numbers of movies
     * @param Movie $movie 
     * @return RatingResource ratings :   the specified movie ratings  
     * 
     */
    public function allRating($movie)
    {
        $ratings = $movie->ratings()->get();
        $ratings = RatingResource::collection($ratings);
        return response()->json([
            'ratings' => $ratings
        ], 200);
    }
    /**
     * show a rating
     * @param Rating $rating 
     * @return RatingResource rating :  the specified rating 
     * 
     */
    public function oneRating($rating)
    {
        $rating = RatingResource::make($rating);
        return response()->json([
            'rating' => $rating
        ], 200);
    }
    /**
     * create a new rating
     * @param array $data 
     * @param Movie $movie 
     * @return Rating rating  
     */
    public function createRating(array $data,  $movie)
    {
        $data['user_id'] = Auth::user()->id;
        $data['movie_id'] = $movie->id;

        return Rating::create($data);
    }
    public function updateRating(array $data,  $rating)
    {
        $rating->update($data);
        return  Rating::find($rating->id);
    }
    /**
     * delete a  specified rating
     * @param Rating $rating 
     * @return bool  
     * 
     */

    public function deleteRating($rating)
    {
        return   $rating->delete();
    }
    /**
     * check if user can rating  on specified movie
     * @param Movie $movie 
     *  @param int user_id
     * @return bool  
     * 
     */
    public  function checkAvilabelRating($movie, $user_id): bool
    {
        $ratings = Rating::userRatings($user_id, $movie->id)->get();
        return !(count($ratings) >= 1);
    }
}
