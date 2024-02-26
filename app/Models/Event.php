<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'venue',
        'start_date',
        'end_date',
        'user_id',
    ];

    /**
     * Get the admin user that created the event
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attendees for the event
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
