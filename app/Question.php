<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    public function answer()
    {
        return $this->belongsTo('App\Answer');
    }
}
