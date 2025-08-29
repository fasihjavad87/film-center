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

    public function statusLabel(): string
    {
        return TicketStatus::from($this->status)->label();
    }

    public function statusPriorityLabel(): string
    {
        return TicketPriorityStatus::from($this->priority)->label();
    }

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
