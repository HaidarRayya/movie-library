<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'director',
        'genre',
        'release_year',
        'discription',
        'image',
        'user_id',
    ];
    public function admin()
    {
        return $this->belongsTo(User::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // sort the  movie by  release_year and if the In case of a wrong entry,
    // it will be searched and sort by the date  in descending order 
    /**
     *
     * @param Builder $query 
     * @param string $sort 
     * @return Builder $query : the movies with this release_year sorted asc or desc
     */

    public function scopeSortingByReleaseYear(Builder $query, $sort)
    {

        if (Str::upper($sort) == "ASC" || Str::upper($sort) == "DESC")
            return $query->orderBy('release_year', $sort);
        else
            return $query->orderByDesc('release_year');
    }
    //search by gener
    /**
     *
     * @param Builder $query 
     * @param string $genre 
     * @return Builder $query : the movies with this gener
     */

    public function scopeByGenre(Builder $query, $genre)
    {
        if ($genre != null)
            return $query->where('genre', '=', $genre);
        else
            return $query;
    }
    //search by director
    /**
     *
     * @param Builder $query 
     * @param string $director 
     * @return Builder $query : the movies with this director
     */

    public function scopeByDirector(Builder $query, $director)
    {
        if ($director != null)
            return $query->where('director', '=', $director);
        else
            return $query;
    }
    //search by title
    /**
     *
     * @param Builder $query 
     * @param string $title 
     * @return Builder $query : the movies with this title
     */

    public function scopeByTitle(Builder $query, $title)
    {
        if ($title != null)
            return $query->where('title', '=', $title);
        else
            return $query;
    }
}