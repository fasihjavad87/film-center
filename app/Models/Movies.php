<?php

namespace App\Models;


use App\Enums\MoviesStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Movies extends Model
{
    protected $fillable = [
        'title',
        'e_name',
        'slug',
        'status',
        'movie_url',
        'movie_file'
    ];



    public function statusLabel(): string
    {
        return MoviesStatus::from($this->status)->label();
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

        static::updating(function ($movie) {
            // اگر پوستر جدید در جزئیات آپدیت شد
            if ($movie->details && $movie->details->isDirty('poster')) {
                $oldPoster = $movie->details->getOriginal('poster');
                if ($oldPoster) {
                    Storage::disk('filament')->delete($oldPoster);
                }
            }
        });

        static::deleting(function ($movie) {
            if ($movie->details) {
                // حذف پوستر از storage
                if ($movie->details->poster) {
                    Storage::disk('filament')->delete($movie->details->poster);
                }

                // حذف رکورد جزئیات
                $movie->details->delete();
            }
        });

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
