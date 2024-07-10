<?php

namespace App\Console\Commands;

use App\Models\DailyRecord;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class DailyRecordUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:record-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating the record of users daily based on the number of users fetched in a day.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $record = new DailyRecord;
        $users = new User;
        $usersToday = $users->getUsersToday();

        if(!empty($usersToday->first())) {
            $maleUsersToday = Redis::get('maleCount');
            $femaleUsersToday = Redis::get('femaleCount');

            $record->createRecord(now(), $maleUsersToday, $femaleUsersToday);
            $this->info('Daily record updates has been executed successfully');
        } else {
            $record->createRecord(now(), 0, 0);
            $this->info('There were no new users today, daily record today will be empty.');
        }
    }
}
