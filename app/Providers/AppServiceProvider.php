<?php

namespace App\Providers;

use App\Models\DailyRecord;
use App\Models\User;
use App\Observers\DailyRecordObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DailyRecord::observe(DailyRecordObserver::class);
        User::observe(UserObserver::class);
    }
}
