<?php

namespace App\Models;

use App\Observers\DailyRecordObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([DailyRecordObserver::class])]
class DailyRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date',
        'male_count',
        'female_count',
        'male_avg_age',
        'female_avg_age',
    ];

        /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'male_avg_count' => 'integer',
        'female_avg_count' => 'integer',
    ];

    protected $appends = [
        'male_avg_count',
        'female_avg_count',
    ];

    // get average male user count 
    public function getMaleAvgCountAttribute()
    {
        $reports = DailyRecord::all();

        $totalUsers = $reports->sum('male_count');
        $averageCount = $totalUsers / $this->id;
        return $averageCount;
    }

    // get average female user count 
    public function getFemaleAvgCountAttribute()
    {
        $reports = DailyRecord::all();

        $totalUsers = $reports->sum('female_count');
        $averageCount = $totalUsers / $this->id;
        return $averageCount;
    }

    public function getDailyRecordToday()
    {
        $dailyRecord = $this::whereDay('created_at', now()->day)->get()->last();
        return $dailyRecord;
    }

    // Create a new record
    public function createRecord($date, $male_count, $female_count)
    {
        $record = new DailyRecord;
        $record->date = $date;
        $record->male_count = $male_count;
        $record->female_count = $female_count;

        $users = new User;

        $record->male_avg_age = $users->getAverageUserAge('male');
        $record->female_avg_age = $users->getAverageUserAge('female');
        $record->save();
    }
}
