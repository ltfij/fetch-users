<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class HourlyFetchUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:fetch-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching a list of users and inserts or updates the user based on the uuid.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://randomuser.me/api/?results=20');

        $user = new User();

        $maleCount = 0;
        $femaleCount = 0;

        foreach($response['results'] as $person) {
            $existingUser = $user->getUser($person['login']['uuid']);

            if(empty($existingUser)) {
                $user->createUser(
                    $person['login']['uuid'],
                    $person['gender'],
                    $person['name']['first'],
                    json_encode($person['name']),
                    json_encode($person['location']),
                    $person['dob']['age'],
                    $person['email'],
                );
                if ($person['gender'] == 'male') {
                    $maleCount++;
                } elseif ($person['gender'] == 'female') {
                    $femaleCount++;
                }
            } else {
                $user->updateUser(
                    $person['gender'],
                    $person['name']['first'],
                    json_encode($person['name']),
                    json_encode($person['location']),
                    $person['dob']['age'],
                    $person['email'],
                );
            }

            // Set a value in Redis cache
            Redis::set('maleCount', $maleCount);
            Redis::set('femaleCount', $femaleCount);
        }

        Log::debug(Redis::get('maleCount'));

        $this->info('Hourly fetch users has been executed successfully');
    }
}
