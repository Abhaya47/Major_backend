<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable=[
        'uid',
        'name',
        'reps',
        'description',
        'performed_time',
        'part'
    ];

    function owner(){
        return $this->belongsTo('App\Models\User','id','uid');
    }

    protected $casts = [
        'performed_time' => 'datetime',
    ];
}
