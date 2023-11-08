<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'genere_id',
        'music_name',
        'music_url',
        'type',
        'thumbnail'
    ];

    public function artist() {
        return $this->belongsTo(User::class ,'user_id','id');
    }

    public function genere() {
        return $this->belongsTo(Genere::class);
    }
}
