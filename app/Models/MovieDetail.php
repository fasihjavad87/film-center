<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class MovieDetail extends Model
{
    protected $fillable = [
        'movieable_id',
        'movieable_type',
        'imdb_id',
        'imdb_rating',
        'release_year',
        'language',
        'age_rating',
        'poster'
    ];

    public function movieable(): MorphTo
    {
        return $this->morphTo();
    }

// در مدل MovieDetail
    protected static function booted(): void
    {
        static::updating(function ($detail) {
            if ($detail->isDirty('poster')) {
                $oldPoster = $detail->getOriginal('poster');
                if ($oldPoster) {
                    Storage::disk('filament')->delete($oldPoster);
                }
            }
        });
    }

}
