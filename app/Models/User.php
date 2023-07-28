<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'surname',
        'email',
        'password',
        'confirmed',
        'average'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role(){
        return $this -> belongsTo(Role::class);
    }

    public function result() {
        return $this -> hasMany(Result::class);
    }

    public function user_data() {
        return $this -> hasOne(User_data::class);
    }

    public function group () {
        return $this->belongsToMany(Group::class, 'user_group', 'user_id', 'group_id');
    }

    public function event () {
        return $this->belongsToMany(Event::class, 'user_event', 'user_id', 'event_id');
    }

    protected $table = 'users';
}
