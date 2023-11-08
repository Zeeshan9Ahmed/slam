<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $hidden = [
        'pivot',
        // 'events.pivot'
    ];
    protected $fillable = ['venue_id','title','location','detail','date', 'start_time','end_time','user_id','is_approved','created_by_artist','event_capacity','status'];
    
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->select('id','image_url','imageable_id');
    }

    public function venue() 
    {
        return $this->belongsTo(Venue::class ,'venue_id', 'id');
    }

    public function user_status() 
    {
        return $this->hasOne(EventUser::class)->where('user_id', auth()->id());
    }

    public function attendess()
    {
        return $this->belongsToMany(User::class,'event_users', 'event_id', 'user_id' )->where([ 'interested' => 1, 'type' => 'user'])->where('user_id', '!=', auth()->id() );
    }

    public function reported_users()
    {
        return $this->belongsToMany(User::class,'event_statuses', 'event_id', 'user_id' )->where(['type' => 'report']);
    }
    public function event_users()
    {
        return $this->hasMany(EventUser::class,'event_id')->where([ 'interested' => 1]);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'event_users', 'event_id', 'user_id' )->where([ 'interested' => 1, 'type' => 'artist']);
    }
    public function users_list()
    {
        return $this->belongsToMany(User::class,'event_users', 'event_id', 'user_id' )->where([ 'interested' => 1]);
    }
    public function artists()
    {
        return $this->belongsToMany(User::class,'event_users', 'event_id', 'user_id' )->where([ 'interested' => 1, 'type' => 'artist']);
    }

    
    public function artist_status () {
        return $this->hasOne(EventUser::class,'event_id')->where(['type' => 'artist' ]);

    }
    public function event_artist()
    {
        return $this->hasMany(EventUser::class,'event_id')->where(['type' => 'artist' ]);
    }

    public function artist()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function approved_by_artist() {
        return $this->hasMany(EventUser::class,'event_id')->where(['type' => 'artist' , 'interested' => 1]);
    }

   
}
