<?php

namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected $table = 'subjects';

    protected $fillable = ['subject_name', 'subject_branch_id', 'level', 'enabled'];

    protected $appends = ['assignedUsers', 'branchName', 'hasSubjectPermission', 'label'];

    public function getlabelAttribute()
    {
       return $this->subject_name;
    }
    public function subject_branch(){
        return $this->belongsTo('App\Models\SubjectBranch');
    }

    public function questions(){
        return $this->hasMany('App\Models\Question')->orderBy('created_at', 'desc');
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

    public function getbranchNameAttribute(){
        return $this->subject_branch->branch_name;
    } 
   
    public function gethasSubjectPermissionAttribute(){
        if(Auth::user()->user_type == 1){
            return true;
        }else{
            foreach($this->assignedUsers as $user){
                if($user->id == Auth::id()){
                    return true;
                }else{
                    continue;
                }
            }
        }
    }

}
