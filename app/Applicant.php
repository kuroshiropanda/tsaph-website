<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'applicants';

    protected $primaryKey = 'twitch_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $attributes = [
        'approved' => false,
    ];

    protected $fillable = [
        'twitch_id', 'username', 'email', 'name'
    ];

    public function application()
    {
        return $this->hasMany('App\Application', 'applicant_id', 'twitch_id');
    }
}
