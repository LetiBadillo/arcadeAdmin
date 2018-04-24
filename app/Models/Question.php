<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $table = 'questions';

    protected $fillable = ['subject_id', 'score', 'difficulty', 'author_id', 'enabled'];

   public function subject(){
       return $this->belongsTo('App\Models\Subject');
   }

   public function author(){
       return $this->belongsTo('App\Models\User');
   }
   
   public function options(){
       return $this->hasMany('App\Models\Option');
   }
}
