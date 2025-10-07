<?php

use App\Enums\SubscriptionPlansStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // نام پلن (طلایی، نقره‌ای، ماهانه، سالانه)
            $table->integer('duration_days'); // مدت زمان به روز
            $table->bigInteger('price'); // قیمت پلن
            $table->text('description')->nullable(); // توضیحات
            $table->unsignedTinyInteger('discount_percent')->nullable();
            $table->string('is_active')->default(SubscriptionPlansStatus::Active->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
