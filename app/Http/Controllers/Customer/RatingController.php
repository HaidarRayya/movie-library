<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\StoreRatingRequest;
use App\Http\Requests\Rating\UpdateRatingRequest;
use App\Models\Movie;
use App\Models\Rating;
use App\Service\RatingService;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    protected $ratingService;
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
        // Determine which processes need to be logged in
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        // check if  the owner of the video is the one performing the operations on it
        // update and delete
        $this->authorizeResource(Rating::class, 'rating');
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * show all movie ratings
     *
     * @param Movie $movie 
     *
     * @return Rating ratings  : a list of movie ratings ratingResource
     */
    public function index(Movie $movie)
    {
        return $this->ratingService->allRating($movie);
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * add a  new rating for specified movie
     * @param StoreRatingRequest $request 
     * @param Movie $movie 
     *
     * @return response  of the status of operation : message and the new rating
     */
    public function store(StoreRatingRequest $request, Movie $movie)
    {

        if (!$this->ratingService->checkAvilabelRating($movie, Auth::user()->id)) {
            return response()->json([
                'message' => 'you can\'t rating this movie you '
            ], 422);
        }
        $rating = $this->ratingService->createRating($request->all(), $movie);
        return response()->json([
            'message' => 'rating  created',
            'rating' => $rating
        ], 201);
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


    /**
     * Update a specified  rating for specified movie
     * @param UpdateRatingRequest $request 
     * @param Movie $movie 
     *@param  Rating $rating
     * @return response  of the status of operation : message and the new update rating
     */
    public function update(UpdateRatingRequest $request, Movie $movie, Rating $rating)
    {
        $rating =  $this->ratingService->updateRating($request->all(), $rating);
        return response()->json([
            'message' => 'rating  updated',
            'rating' => $rating
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * delete a specified  rating for specified movie
     * @param Movie $movie 
     *@param  Rating $rating
     * @return response  of the status of operation : message 
     */
    public function destroy(Movie $movie, Rating $rating)
    {
        $this->ratingService->deleteRating($rating);
        return response()->json([
            'message' => 'rating  deleted'
        ], 204);
    }
}
