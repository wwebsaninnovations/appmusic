<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class TodayOrFuture implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Carbon::parse($value)->isToday() && !Carbon::parse($value)->isFuture()) {
            $fail('The :attribute must be today or a future date.');
        }
    }
}

