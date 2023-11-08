<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'address',
        'lat',
        'lang',
        'capacity',
        'detail',
        'user_id',
        'phone_number',
        'start_time',
        'end_time'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
