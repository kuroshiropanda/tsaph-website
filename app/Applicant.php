<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Applicant extends Model
{
    use LogsActivity;

    protected $table = 'applicants';

    protected $attributes = [
        'approved' => false,
        'denied' => false,
        'invited' => false,
    ];

    protected $fillable = [
        'twitch_id', 'username', 'email', 'name', 'avatar'
    ];

    protected static $logAttributes = [
        'twitch_id', 'username', 'discord', 'name', 'approved', 'denied', 'invited'
    ];

    protected static $recordEvents = [
        'created', 'updated'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function discord()
    {
        return $this->hasOne('App\Discord');
    }

    public function answers()
    {
        return $this->belongsToMany('App\Answer')->using('App\ApplicantAnswer')->withPivot(['question_id']);
    }

    public function types()
    {
        return $this->belongsToMany('App\Type')->using('App\ApplicantType');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function reason()
    {
        return $this->hasMany('App\Reason');
    }
}
