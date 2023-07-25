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
        'created_at',
        'updated_at'
    ];

    public function user() {
        return $this -> belongsTo(User::class);
    }

    protected $table = 'results';
}
