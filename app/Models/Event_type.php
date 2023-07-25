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

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    protected $table = 'event_type';
}
