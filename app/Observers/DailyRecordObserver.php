<?php

namespace App\Observers;

use App\Models\DailyRecord;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

class DailyRecordObserver
{
    /**
     * Handle the DailyRecord "created" event.
     */
    public function created(DailyRecord $dailyRecord): void
    {
        //
    }

    /**
     * Handle the DailyRecord "updated" event.
     */
    public function updated(DailyRecord $dailyRecord): void
    {
        $users = new User;

        $dailyRecord->male_avg_age = $users->getAverageUserAge('male');
        $dailyRecord->female_avg_age = $users->getAverageUserAge('female');
        $dailyRecord->saveQuietly();
    }

    /**
     * Handle the DailyRecord "deleted" event.
     */
    public function deleted(DailyRecord $dailyRecord): void
    {
        //
    }

    /**
     * Handle the DailyRecord "restored" event.
     */
    public function restored(DailyRecord $dailyRecord): void
    {
        //
    }

    /**
     * Handle the DailyRecord "force deleted" event.
     */
    public function forceDeleted(DailyRecord $dailyRecord): void
    {
        //
    }
}
