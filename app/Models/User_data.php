<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_data extends Model
{
    use HasFactory;

    protected $fillable = [
        'surname',
        'contact_email',
        'first_phone',
        'second_phone',
        'birth_date',
        'dni'
    ];

    public function user() {
        return $this -> belongsTo(User::class);
    }

    protected $table = 'user_data';
}
