<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class TodayOrPast implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Carbon::parse($value)->isToday() && !Carbon::parse($value)->isPast()) {
            $fail('The :attribute must be today or a past date.');
        }
    }
}

