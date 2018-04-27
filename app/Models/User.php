<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'enabled', 'user_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['label'];

    public function subjects(){
        return $this->hasManyThrough(Subject::class, SubjectPermission::class);
    }

    public function questions(){
        return $this->hasMany('App\Models\Question');
    }

    public function getlabelAttribute()
    {
       return $this->name.' '.$this->last_name;
    }
}
