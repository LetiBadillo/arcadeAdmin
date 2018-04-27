<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected $table = 'subjects';

    protected $fillable = ['subject_name', 'subject_branch_id', 'level', 'enabled'];

    protected $appends = ['assignedUsers'];


    public function subject_branch(){
        return $this->hasOne('App\Models\SubjectBranch');
    }

    public function questions(){
        return $this->hasMany('App\Models\Question');
    }

    public function topScores(){
        return $this->hasMany('App\Models\Score');
    }
    
    public function permissions(){
        return $this->hasMany('App\Models\SubjectPermission', 'subject_id');
    }
   

    public function getassignedUsersAttribute(){
        $array = array();
        foreach($this->permissions as $permission){
            array_push($array, $permission->user);
        }
        return $array;
    }

}
