<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
