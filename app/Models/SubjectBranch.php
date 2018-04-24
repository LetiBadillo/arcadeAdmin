<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectBranch extends Model
{
    //
    protected $table = 'subject_branches';

    protected $fillable = ['branch_name'];
   
    public function subjects(){
        return $this->belongsTo('App\Models\Subject');
    }
}
