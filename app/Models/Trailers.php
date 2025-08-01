<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Trailers extends Model
{
    protected $fillable = [
        'trailerable_id',
        'trailerable_type',
        'title',
        'video_url',
        'video_file',
        'duration',
        'order'
    ];

    public function trailerable(): MorphTo
    {
        return $this->morphTo();
    }

}
