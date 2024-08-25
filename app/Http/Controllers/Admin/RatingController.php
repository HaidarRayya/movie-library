<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Rating;
use App\Service\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $ratingService;
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * show all movie ratings
     *
     * @param Movie $movie 
     *
     * @return Rating ratings  : a list of movie ratings
     */
    public function index(Movie $movie)
    {
        return  $this->ratingService->allRating($movie);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * show all specified a rating
     *
     * @param Movie $movie 
     * @param Rating $rating 
     * @return Rating rating : ratingResource
     */
    public function show(Movie $movie, Rating $rating)
    {
        return $this->ratingService->oneRating($rating);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie, Rating $rating)
    {
        //
    }
}
