<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    protected $table = 'user_event';
}