<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $table = 'reasons';

    protected $fillable = [
        'reason'
    ];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant');
    }
}
