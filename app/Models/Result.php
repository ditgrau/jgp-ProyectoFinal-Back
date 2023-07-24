<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'difficulty',
        'artistic',
        'execution',
        'total',
        'ranking'
    ];
    
    protected $hidden = [
        'timestamps',
    ];


    public function user() {
        return $this -> belongsTo(User::class);
    }

    protected $table = 'results';
}
