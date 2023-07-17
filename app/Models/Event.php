<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public function event_type(){
        return $this -> belongsTo(Event_type::class);
    }

    public function user () {
        return $this->belongsToMany(User::class, 'user_group', 'event_id', 'user_id');
    }

    protected $table = 'event';
}
