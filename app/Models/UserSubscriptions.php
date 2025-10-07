<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSubscriptions extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'payment_id' ,  'start_date', 'end_date', 'is_active'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlans::class, 'plan_id');
    }
}

