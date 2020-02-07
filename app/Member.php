<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $table = 'members';

    protected $primaryKey = 'twitch_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'twitch_id', 'username', 'avatar'
    ];
}
