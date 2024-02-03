<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'calorie',
        'uid',
        'consumed_time',
        'count',
    ];

    protected $casts = [
        'consumed_time' => 'datetime',
    ];

    function owner(){
        return $this->belongsTo('App\Models\User','uid','id');
    }

}
