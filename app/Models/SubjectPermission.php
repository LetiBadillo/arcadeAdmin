<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectPermission extends Model
{
    //
    protected $table = 'subjects_permissions';

    protected $fillable = ['user_id', 'subject_id', 'enabled'];


   public function user(){
       return $this->belongsTo('App\Models\User', 'user_id');
   }

   public function assigned(){
    return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
   }
}
