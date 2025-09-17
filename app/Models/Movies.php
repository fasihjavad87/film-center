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
        'description',
        'e_name',
        'slug',
        'status',
        'runtime',
        'movie_url',
        'movie_file'
    ];


//    public function statusLabel(): string
//    {
//        return MoviesStatus::from($this->status)->label();
//    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'active' => 'فعال',
            'inactive' => 'غیر فعال',
            default => 'نامشخص',
        };
    }

    // متد برای کلاس CSS وضعیت
    public function statusClasses(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800 border-green-400/30 px-2 badge-custom-panel-form',
            'inactive' => 'bg-red-100 text-red-800 border-red-400/30 px-2 badge-custom-panel-form',
            default => 'bg-gray-200 text-gray-600 px-2 badge-custom-panel-form',
        };
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

        static::updated(function ($movie) {
            // فقط اگر رابطه details لود شده باشد
            if ($movie->relationLoaded('details') && $movie->details) {
                $currentPoster = $movie->details->poster;
                $originalDetails = $movie->details->getOriginal();

                if (isset($originalDetails['poster']) &&
                    $originalDetails['poster'] !== $currentPoster &&
                    $originalDetails['poster']) {
                    Storage::disk('filament')->delete($originalDetails['poster']);
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

            // حذف تریلرها
            $movie->trailers()->each(function ($trailer) {
                $trailer->delete();
            });

            // حذف رکوردهای pivot از کشورها
            $movie->countries()->detach();

            // حذف رکوردهای pivot از دسته‌بندی‌ها
            $movie->categories()->detach();
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
