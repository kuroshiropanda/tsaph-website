<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    protected $fillable = [
        'answer', 'question_id'
    ];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant');
    }

    public function question()
    {
        return $this->hasOne('App\Question');
    }
}
