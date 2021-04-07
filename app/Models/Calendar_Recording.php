<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar_Recording extends Model
{
    //
    protected $table = 'calendar_recording';
    protected $fillable = [
        'title',
        'title__2',
        'title__3',
        'description',
        'description__2',
        'description__3',
        'food_file_name',
        'food_file_path',
        'food_file_name__2',
        'food_file_path__2',
        'food_file_name__3',
        'food_file_path__3'
    ];
}
