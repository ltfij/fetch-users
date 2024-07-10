<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'name_jsonb',
        'gender',
        'location',
        'age',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:00A',
    ];

    // Consult records
    public function getUser($uuid)
    {
        $user = $this::where('uuid', $uuid)->first();

        if (empty($user)) {
            return 0;
        } else {
            return $user;
        }
    }

    public function getUsersToday()
    {
        $user = $this::whereDay('created_at', now()->day)->get();
        return $user;
    }

    public function getAverageUserAge($gender)
    {
        $users = $this::where('gender', $gender)->get();
        if(!empty($users->first())) {
            return $users->average('age');
        } else {
            return null;
        }
    }

    // maybe do createOrUpdate

    // Create a new record
    public function createUser($uuid, $gender, $name, $name_jsonb, $location, $age, $email)
    {
        $user = new User;
        $user->uuid = $uuid;
        $user->gender = $gender;
        $user->name = $name;
        $user->name_jsonb = $name_jsonb;
        $user->location = $location;
        $user->age = $age;
        $user->email = $email;
        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password
        $user->save();
    }

    // Update an existing record
    public function updateUser($gender, $name, $name_jsonb, $location, $age)
    {
        $user = new User;
        $user->gender = $gender;
        $user->name = $name;
        $user->name_jsonb = $name_jsonb;
        $user->location = $location;
        $user->age = $age;
        $user->save();
    }

    // Delete an existing record
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
