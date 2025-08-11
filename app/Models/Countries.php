<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Countries extends Model
{
    protected $fillable = [
        'name_en',
        'name_fa',
        'code'
    ];

    public function movieables(): MorphToMany
    {
        return $this->morphedByMany(Movies::class, 'movieable', 'country_moviedetail');
    }

    public function seriesables(): MorphToMany
    {
        return $this->morphedByMany(Series::class, 'movieable', 'country_moviedetail');
    }


}
