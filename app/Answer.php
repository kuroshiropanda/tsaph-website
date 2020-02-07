<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    public $timestamps = false;

    protected $fillable = [
        'answer'
    ];

    public function applicant()
    {
        return $this->belongsToMany('App\Applicant')->using('App\ApplicantAnswer')->withPivot(['question_id']);
    }

    public function question()
    {
        return $this->belongsTo('App\Question', 'answer_applicant', 'question_id');
    }
}
