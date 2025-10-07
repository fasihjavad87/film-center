<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Payment;

//if (! function_exists('generate_unique_ref')) {
//    function generate_unique_ref(string $prefix = '', int $len = 10): string {
//        do {
//            $ref = $prefix . strtoupper(Str::random($len)); // یا Str::uuid()
//        } while (Payment::where('ref_id', $ref)->exists());
//        return $ref;
//    }
//}
if (!function_exists('generate_unique_ref')) {
    /**
     * تولید یک کد مرجع (Ref ID) یونیک با وزن بیشتر برای اعداد.
     * بخش ترکیبی (حروف و عدد) در وسط کد قرار می گیرد.
     *
     * @param string $prefix پیشوند کد (مثلاً PAY-)
     * @param int $len طول بخش رندوم کد (به جز پیشوند)
     * @return string
     */
    function generate_unique_ref(string $prefix = '', int $len = 10): string
    {
        // تعیین طول بخش ترکیبی (حروف و عدد) - حدود ۴۰ درصد طول کل
        $alphaNumericLen = (int)round($len * 0.4);
        // تعیین طول بخش فقط عددی برای دو طرف بخش ترکیبی
        $remainingLen = $len - $alphaNumericLen;
        $numericLen1 = (int)floor($remainingLen / 2); // بخش اول عددی
        $numericLen2 = $remainingLen - $numericLen1;    // بخش دوم عددی
        // کاراکترهای مجاز برای بخش ترکیبی (حروف بزرگ و اعداد)
        $allowedChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do {
            // ۱. تولید بخش اول فقط عددی
            $numericPart1 = Str::random($numericLen1, '0123456789');
            // ۲. تولید بخش میانی ترکیبی (حروف و عدد)
            $alphaNumericPart = Str::random($alphaNumericLen, $allowedChars);
            // ۳. تولید بخش دوم فقط عددی
            $numericPart2 = Str::random($numericLen2, '0123456789');
            // ترکیب بخش ها: پیشوند + عدد۱ + ترکیبی + عدد۲
            $ref = $prefix . $numericPart1 . $alphaNumericPart . $numericPart2;
        } while (Payment::where('ref_id', $ref)->exists());
        return $ref;
    }
}


if (! function_exists('calculate_end_date')) {
    function calculate_end_date($start, int $days)
    {
        $startCarbon = $start instanceof \DateTime
            ? Carbon::instance($start)
            : Carbon::parse($start);

        return $startCarbon->copy()->addDays($days);
    }
}
