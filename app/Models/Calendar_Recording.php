<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar_Recording extends Model
{
    //
    protected $table = 'calendar_recording';
    protected $fillable = [
        'description',
    ];
}
