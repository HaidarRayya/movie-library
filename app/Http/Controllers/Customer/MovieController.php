<?php

namespace App\Http\Controllers\Customer;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\MovieService;

class MovieController extends Controller
{
    protected $movieService;
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
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
        return   $this->movieService->allMovie($request);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie) {}
}
