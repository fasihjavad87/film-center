<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Episode extends Model
{
    protected $fillable = [
        'season_id',
        'title',
        'episode_number',
        'episode_url',
        'episode_file',
        'runtime'
    ];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

}
