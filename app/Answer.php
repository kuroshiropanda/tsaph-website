<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    protected $fillable = [
        'answer'
    ];

    public function application()
    {
        return $this->belongsTo('App\Application', 'answer_id');
    }
}
