<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Friendable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'full_name',
        'bio',
        'avatar',
        'profile_completed',
        'device_type',
        'device_token',
        'password',
        'role',
        'email_verified_at',
        'social_links',
        'skills',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
        // 'events.pivot'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function following() {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
                        ->where('is_accepted',1);
    }
    
    // users that follow this user
    public function followers() {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
                    ->where('is_accepted',1);
    }

    public function pending_requests() {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
                    ->where('is_accepted',0);
    }

    public function events () 
    {
        return $this->belongsToMany(Event::class, 'event_users', 'user_id', 'event_id')->where('interested', true);
    }

    public function audio()
    {
        return $this->hasMany(Music::class)->where('type', 'audio');
    }

    public function video()
    {
        return $this->hasMany(Music::class)->where('type', 'video');
    }

    public function venue()
    {
        return $this->hasOne(Venue::class);
    }
}
