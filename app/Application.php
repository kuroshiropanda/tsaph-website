<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'applicant_id', 'answer_id', 'question_id'
    ];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant', 'applicant_id', 'twitch_id');
    }

    public function answer()
    {
        return $this->hasMany('App\Answer', 'id', 'answer_id');
    }

    public function question()
    {
        return $this->hasMany('App\Question', 'id', 'question_id');
    }
}
