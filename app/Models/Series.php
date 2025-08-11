<?php

namespace App\Models;

use App\Enums\MoviesStatus;
use App\Enums\SeriesStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Series extends Model
{
    protected $fillable = [
        'title',
        'description',
        'e_name',
        'slug',
    ];

    public function statusLabel(): string
    {
        return SeriesStatus::from($this->status)->label();
    }

    // تابعی که می‌خوایم برای ساخت خودکار اسلاگ
    public static function generateSlug($eName): string
    {
        return Str::slug($eName);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = self::generateSlug($model->e_name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('e_name') && empty($model->slug)) {
                $model->slug = self::generateSlug($model->e_name);
            }
        });

        static::updated(function ($series) {
            // فقط اگر رابطه details لود شده باشد
            if ($series->relationLoaded('details') && $series->details) {
                $currentPoster = $series->details->poster;
                $originalDetails = $series->details->getOriginal();

                if (isset($originalDetails['poster']) &&
                    $originalDetails['poster'] !== $currentPoster &&
                    $originalDetails['poster']) {
                    Storage::disk('filament')->delete($originalDetails['poster']);
                }
            }
        });

        static::deleting(function ($series) {
            if ($series->details) {
                // حذف پوستر از storage
                if ($series->details->poster) {
                    Storage::disk('filament')->delete($series->details->poster);
                }

                // حذف رکورد جزئیات
                $series->details->delete();
            }
        });

    }


    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'movieable', 'categorizables');
    }

    public function details(): MorphOne
    {
        return $this->morphOne(MovieDetail::class, 'movieable');
    }

    public function trailers(): MorphMany
    {
        return $this->morphMany(Trailers::class, 'trailerable');
    }

    public function countries(): MorphToMany
    {
        return $this->morphToMany(Countries::class, 'movieable', 'country_moviedetail', 'movieable_id', 'country_id');
    }

}
