<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';

    public function applicant()
    {
        return $this->belongsToMany('App\Applicant')->using('App\ApplicantType');
    }
}
