<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'e_name', 'slug'];

    // تابعی که می‌خوایم برای ساخت خودکار اسلاگ
    public static function generateSlug($eName)
    {
        return Str::slug($eName);
    }

    protected static function boot()
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
    }

    public function movies(): MorphToMany
    {
        return $this->morphedByMany(Movies::class, 'movieable', 'categorizables');
    }

    public function series(): MorphToMany
    {
        return $this->morphedByMany( Series::class, 'movieable', 'categorizables');
    }

}
