<?php

namespace App\Observers;

use App\Models\DailyRecord;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

class UserObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // get latest daily record
        $dailyRecord = new DailyRecord;
        $dailyRecord = $dailyRecord->getDailyRecordToday();

        if (!empty($dailyRecord)) {
            if ($user->gender == 'male') {
                $dailyRecord->male_count =- 1;
                $dailyRecord->male_avg_age = $user->getAverageUserAge('male');
            } elseif ($user->gender == 'female') {
                $dailyRecord->female_count =- 1;
                $dailyRecord->female_avg_age = $user->getAverageUserAge('female');
            }
            $dailyRecord->saveQuietly();
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
