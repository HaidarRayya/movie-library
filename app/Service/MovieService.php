<?php

namespace App\Service;

use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MovieService
{

    /**
     * show a numbers of movies
     * @param Request $request 
     * @return MovieResource moives :  the movies sorted by release_year and filtering by  genre and director and title and spescifed a  number_of_movies
     * 
     */
    public function allMovie($request)
    {
        $number_of_movies = $request->input("number_of_movies");

        $genre = $request->input("genre");
        $director = $request->input("director");
        $title = $request->input("title");
        $sort = $request->input("sort");

        $movies =  Movie::query();

        $movies = $movies->byGenre($genre)
            ->byDirector($director)
            ->byTitle($title)
            ->sortingByReleaseYear($sort)
            ->paginate($number_of_movies);
        $movies = MovieResource::collection($movies);
        return $movies;
    }

    /**
     * show a movie
     * @param Movie $movie 
     * @return MovieResource moive :  the specified movie 
     * 
     */
    public function oneMovie($movie)
    {
        $movie = MovieResource::make($movie);
        return response()->json([
            'movie' => $movie
        ], 200);
    }

    /**
     * create new movie
     * @param Request $data 
     * @return Movie $movie 
     * 
     */
    public function createMovie($data)
    {
        $movieData = $data->all();
        $movieData['user_id'] = Auth::user()->id;

        if ($data->hasFile('image')) {
            $movieData['image'] = $data->file('image')->store('imagesMovie', 'public');
        }

        $movie = Movie::create($movieData);
        return $movie;
    }
    /**
     * update a  specified movie
     * @param Request $data 
     * @return Movie $movie 
     * 
     */
    public function updateMovie($data,  $movie)
    {
        $movieData = $data->all();

        if ($data->hasFile('image')) {
            Storage::disk('public')->delete($movie->image);
            $movieData['image'] = $data->file('image')->store('imagesMovie', 'public');
        }
        $movie->update($movieData);
        return Movie::find($movie->id);
    }
    /**
     * delete a  specified movie
     * @param Movie $movie 
     * @return bool  
     * 
     */

    public function deleteMovie($movie)
    {
        Storage::disk('public')->delete($movie->image);
        return $movie->delete();
    }
}
