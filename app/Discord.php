<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discord extends Model
{
    protected $table = 'discords';

    protected $fillable = [
        'discord_id', 'username', 'email', 'avatar', 'token'
    ];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant');
    }
}
