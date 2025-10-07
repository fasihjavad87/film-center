<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'amount', 'status' , 'transaction_id', 'gateway', 'ref_id' , 'discount'];

    protected $casts = [
        'status' => PaymentStatus::class,
    ];

    public function statusLabel(): string
    {
        return match($this->status) {
            PaymentStatus::Paid => 'پرداخت شده',
            PaymentStatus::Failed => 'پرداخت نشده',
            PaymentStatus::Canceled => 'لغو شده',
            PaymentStatus::Pending => 'در انتظار پرداخت',
            default => 'نامشخص',
        };
    }

    // متد برای کلاس CSS وضعیت
    public function statusClasses(): string
    {
        return match($this->status) {
            PaymentStatus::Paid => 'bg-green-300 text-green-800 border-green-400/30 px-2 badge-custom-panel-form',
            PaymentStatus::Failed => 'bg-red-100 text-red-800 border-red-400/30 px-2 badge-custom-panel-form',
            PaymentStatus::Canceled => 'bg-gray-100 text-gray-800 dark:bg-gray-500 dark:text-white border-gray-400/30 px-2 badge-custom-panel-form',
            PaymentStatus::Pending => 'bg-yellow-100 text-yellow-800 border-yellow-400/30 px-2 badge-custom-panel-form',
            default => 'bg-gray-200 text-gray-600 px-2 badge-custom-panel-form',
        };
    }
//    public function statusClasses(): string
//    {
//        return match($this->status) {
//            'paid' => 'bg-green-100 text-green-800 border-green-400/30 px-2 badge-custom-panel-form',
//            'failed' => 'bg-red-100 text-red-800 border-red-400/30 px-2 badge-custom-panel-form',
//            'canceled' => 'bg-gray-100 text-gray-800 border-gray-400/30 px-2 badge-custom-panel-form',
//            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-400/30 px-2 badge-custom-panel-form',
//            default => 'bg-gray-200 text-gray-600 px-2 badge-custom-panel-form',
//        };
//    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlans::class, 'plan_id');
    }
}

