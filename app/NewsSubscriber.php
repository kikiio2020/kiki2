<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsSubscriber extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'email',
        'country',
        'region',
    ];
}
