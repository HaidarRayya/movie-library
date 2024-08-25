<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'rating',
        'review',
        'movie_id',
        'user_id',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    // Specific user ratings on a specific movie 
    /**
     *
     * @param Builder $query 
     * @param int $user_id
     * @param int $movie_id
     * @return Builder $query : the rating belongs to this user
     */
    public function scopeUserRatings(Builder $query, $user_id, $movie_id)
    {
        return $query->where('user_id', '=', $user_id)->where('movie_id', '=', $movie_id);
    }
}
