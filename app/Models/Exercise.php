<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    public $table = 'exercise';

    public $timestamps = false;

    protected $fillable = [
        'uid',
        'name',
        'reps',
        'description',
        'performed_time',
    ];

    function owner()
    {
        return $this->belongsTo('App\Models\User', 'id', 'uid');
    }

    protected $casts = [
        'performed_time' => 'datetime',
    ];
}
