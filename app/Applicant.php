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
        'twitch_id', 'username', 'name'
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "An Applicant has been {$eventName}";
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
