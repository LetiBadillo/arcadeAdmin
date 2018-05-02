<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Question extends Model
{
    //
    protected $table = 'questions';

    protected $fillable = ['question', 'subject_id', 'difficulty', 'author_id', 'enabled'];

    protected $appends = ['answer', 'otheroptions', 'authorName', 'hasQuestionPermission'];

   public function subject(){
       return $this->belongsTo('App\Models\Subject');
   }

   public function author(){
       return $this->belongsTo('App\Models\User');
   }
   
   public function options(){
       return $this->hasMany('App\Models\Option')->orderBy('id', 'asc');
   }
  
   public function getanswerAttribute(){
        $answer = '';
        foreach($this->options as $option){
            if($option->is_answer == true){
                $answer = $option->option;
            }
        }
        return $answer;
    }

    public function getotheroptionsAttribute(){
        $array = array();
        foreach($this->options as $option){
            if($option->is_answer == true){
                continue;
            }
            array_push($array, $option->option);
        }
    return $array;
    }
    public function getauthorNameAttribute(){
        return $this->author->label;
    }

    public function gethasQuestionPermissionAttribute(){
        if(Auth::user()->user_type == 1){
            return true;
        }else{
            if($this->author_id == Auth::id()){
                return true;
            }else{
                return false;
            }
        }
    }

    
    
    
}
