<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    //
    protected $table = 'subject_branches';

    protected $fillable = ['subject_id', 'username', 'score'];

    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }
}
