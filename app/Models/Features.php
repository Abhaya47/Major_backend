<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $primaryKey = "uid";
    protected $fillable=[
        'uid',
        'bmi',
        'weight',
        'height',
        'pressure'
    ];

    function owner(){
        return $this->belongsTo('App\Models\User','id','uid');

    }
}
