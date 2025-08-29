<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class TicketMessage extends Model
{
    protected $fillable = [
        'ticket_id',
        'sender_id',
        'message',
        'attachments',
        'read_at'
    ];

    protected $casts = [
        'attachments' => 'array',
        'read_at'     => 'datetime',
    ];

    // تیکتی که این پیام بهش تعلق داره
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }

    // یوزری که پیام رو ارسال کرده (کاربر یا ادمین)
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    protected $appends = ['is_from_admin'];

    public function getIsFromAdminAttribute(): bool
    {
        return (bool) $this->sender?->is_admin;
    }
}
