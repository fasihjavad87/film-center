<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MovieDetail extends Model
{
    protected $fillable = [
        'movieable_id',
        'movieable_type',
        'imdb_id',
        'imdb_rating',
        'release_year',
        'language',
        'runtime',
        'age_rating',
        'poster'
    ];

    public function movieable(): MorphTo
    {
        return $this->morphTo();
    }



}
