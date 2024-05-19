<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Validator::extend('index_increment', function ($attribute, $value, $parameters, $validator) {
            return true; // This rule always passes
        });

        Validator::replacer('index_increment', function ($message, $attribute, $rule, $parameters) {
            // Extract the index from the attribute
            if (preg_match('/\d+/', $attribute, $matches)) {
                // Increment the index by 1
                $index = $matches[0] + 1;
                return str_replace(':index', $index, $message);
            }
            return $message;
        });
    }
}
