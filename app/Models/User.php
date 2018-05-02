<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
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

    protected $appends = ['label', 'permission'];

    public function subjects(){
        return $this->hasMany(SubjectPermission::class);
    }

    public function questions(){
        return $this->hasMany('App\Models\Question');
    }

    public function getlabelAttribute()
    {
       return $this->name.' '.$this->last_name;
    }
    public function getpermissionAttribute()
    {
        if(request()->subject_id){
            foreach($this->subjects as $subject){
                if($subject->subject_id == request()->subject_id){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return null;
        }
    }
}
