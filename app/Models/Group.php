<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function user () {
        return $this->belongsToMany(User::class, 'user_group','group_id', 'user_id');
    }
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $table = 'group';
}
