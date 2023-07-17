<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_type extends Model
{
    use HasFactory;

    public function event(){
        return $this -> hasMany(Event::class);
    }

    protected $table = 'event_type';
}
