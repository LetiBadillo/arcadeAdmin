<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectBranch extends Model
{
    //
    protected $table = 'subject_branches';

    protected $fillable = ['branch_name'];

    protected $appends = ['label'];
   
    public function subjects(){
        return $this->belongsTo('App\Models\Subject');
    }

    public function getlabelAttribute()
    {
       return $this->branch_name;
    }
}
