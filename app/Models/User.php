<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
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
        'password' => 'hashed',
    ];

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * Get the notices belonging to the User(admin)
     */
    public function notices()
    {
        return $this->hasMany(Notice::class);
    }

    /**
     * Get the events belonging to the User(admin)
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get the events that the user is booked for
     */
    public function eventsBooked()
    {
        return $this->belongsToMany(Event::class);
    }
}
