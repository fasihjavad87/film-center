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

//    public function statusLabel(): string
//    {
//        return SeriesStatus::from($this->status)->label();
//    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'ongoing' => 'در حال پخش',
            'ended' => 'پایان یافته',
            default => 'نامشخص',
        };
    }

    // متد برای کلاس CSS وضعیت
    public function statusClasses(): string
    {
        return match($this->status) {
            'ongoing' => 'bg-yellow-100 text-yellow-800 border-yellow-400/30 px-2 badge-custom-panel-form',
            'ended' => 'bg-green-100 text-green-800 border-green-400/30 px-2 badge-custom-panel-form',
            default => 'bg-gray-200 text-gray-600 px-2 badge-custom-panel-form',
        };
    }


}
