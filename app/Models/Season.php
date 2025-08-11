<?php

namespace App\Models;

use App\Enums\SeriesStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Season extends Model
{
    protected $fillable = [
        'series_id',
        'title',
        'season_number',
        'description',
        'status'
    ];

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function statusLabel(): string
    {
        return SeriesStatus::from($this->status)->label();
    }


}
