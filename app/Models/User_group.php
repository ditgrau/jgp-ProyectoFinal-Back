<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_group extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function group() {
        return $this->belongsTo(Group::class, 'group_id');
    }

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    protected $table = 'user_group';
}
