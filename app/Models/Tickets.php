<?php

namespace App\Models;

use App\Enums\TicketPriorityStatus;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tickets extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'status',
        'priority',
        'assigned_to',
        'last_reply_at'
    ];

//    public function statusLabel(): string
//    {
//        return TicketStatus::from($this->status)->label();
//    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'open' => 'باز',
            'pending' => 'در انتظار پاسخ',
            'closed' => 'بسته شده',
            'answered' => 'پاسخ داده‌شده',
            default => 'نامشخص',
        };
    }

    // متد برای کلاس CSS وضعیت
    public function statusClasses(): string
    {
        return match($this->status) {
            'open' => 'bg-blue-100 text-blue-800 border-blue-400/30 px-[18px] badge-custom-panel-form',
            'answered' => 'bg-green-100 text-green-800 border-green-400/30 px-2 badge-custom-panel-form',
            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-400/30 px-2 badge-custom-panel-form',
            'closed' => 'bg-red-100 text-red-800 border-red-400/30 px-2 badge-custom-panel-form',
            default => 'bg-gray-200 text-gray-600 px-2 badge-custom-panel-form',
        };
    }

    public function statusPriorityLabel(): string
    {
        return match($this->priority) {
            'low' => 'زیاد',
            'medium' => 'متوسط',
            'high' => 'کم',
            default => 'نامشخص',
        };
    }

    // متد برای کلاس CSS وضعیت
    public function statusPriorityClasses(): string
    {
        return match($this->priority) {
            'high' => 'bg-blue-100 text-blue-800 border-blue-400/30 px-2 badge-custom-panel-form',
            'medium' => 'bg-yellow-100 text-yellow-800 border-yellow-400/30 px-2 badge-custom-panel-form',
            'low' => 'bg-red-100 text-red-800 border-red-400/30 px-2 badge-custom-panel-form',
            default => 'bg-gray-200 text-gray-600 px-2 badge-custom-panel-form',
        };
    }
    protected static function booted()
    {
        parent::boot();

        static::deleting(function ($ticket) {
            $ticket->messages()->detach();
        });
    }

//    public function statusPriorityLabel(): string
//    {
//        return TicketPriorityStatus::from($this->priority)->label();
//    }

    protected $casts = [
        'last_reply_at' => 'datetime',
    ];

    // ارتباط با کاربری که تیکت رو باز کرده
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ارتباط با ادمین مسئول تیکت
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // پیام‌های داخل تیکت
    public function messages()
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id');
    }

    // آخرین پیام تیکت
    public function lastMessage()
    {
        return $this->hasOne(TicketMessage::class, 'ticket_id') // دقت کن
        ->latestOfMany();
    }

}
