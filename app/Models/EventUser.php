<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'interested',
        'type'
    ];
    use HasFactory;

    public  function user()
    {
        return $this->belongsTo(User::class, 'user_id' , 'id');
    }
}
