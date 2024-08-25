<?php

namespace App\Http\Controllers\Admin;

use App\Models\Movie;
use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\StoreMovieRequest;
use App\Http\Requests\Movie\UpdateMovieRequest;
use App\Http\Resources\MovieResource;

use App\Service\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
        // check if  the owner of the video is the one performing the operations on it
        // update and delete
        $this->authorizeResource(Movie::class, 'movie');
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * show all movie
     *
     * @param Request $request 
     *
     * @return response a list of movies : MovieResourses
     */
    public function index(Request $request)
    {

        return  $this->movieService->allMovie($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * add a new movie
     *
     * @param StoreMovieRequest $request 
     *
     * @return response  of the status of operation : message and the new movie
     */
    public function store(StoreMovieRequest $request)
    {

        $movie = $this->movieService->createMovie($request);
        $movie  = MovieResource::make($movie);
        return response()->json([
            "message" => 'movie created',
            'movie' => $movie
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    /**
     *  show a specific  movie
     *
     * @param Movie $movie 
     *
     * @return  MovieResourse of the movie 
     */
    public function show(Movie $movie)
    {
        return   $this->movieService->oneMovie($movie);
    }
    /**
     * Update the specified resource in storage.
     */
    /**
     *  update a specific  movie
     *
     * @param UpdateMovieRequest $request 
     * @param Movie $movie 
     *
     * @return response  of the status of operation : message and the updated movie
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $movie = $this->movieService->updateMovie($request, $movie);
        $movie  = MovieResource::make($movie);
        return response()->json([
            "message" => 'movie updated',
            'movie' => $movie
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     *  remove a specific  movie
     *
     * @param Movie $movie 
     *
     * @return response  of the status of operation : message 
     */
    public function destroy(Movie $movie)
    {
        $this->movieService->deleteMovie($movie);
        return response()->json([
            "message" => 'movie delated'
        ], 204);
    }
}
