<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    public function application()
    {
        return $this->belongsTo('App\Application', 'question_id');
    }
}
