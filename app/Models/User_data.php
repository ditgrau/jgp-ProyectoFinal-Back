<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_data extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contact_email',
        'first_phone',
        'second_phone',
        'birth_date',
        'dni'
    ];

    public function user() {
        return $this -> belongsTo(User::class);
    }

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $table = 'user_data';
}
