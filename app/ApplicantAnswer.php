<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class ApplicantAnswer extends Pivot
{
    protected $table = 'answer_applicant';

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}
