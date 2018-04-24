<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
    protected $table = 'options';

    protected $fillable = ['question_id', 'option', 'is_answer', 'enabled'];

    public function question(){
        return $this->belongsTo('App\Models\Question');
    }
}
