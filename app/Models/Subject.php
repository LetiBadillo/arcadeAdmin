<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected $table = 'subjects';

    protected $fillable = ['subject_name', 'subject_branch_id', 'level', 'enabled'];


    public function subject_branch(){
        return $this->hasOne('App\Models\SubjectBranch');
    }

    public function questions(){
        return $this->hasMany('App\Models\Question');
    }

    public function topScores(){
        return $this->hasMany('App\Models\Score');
    }

}
