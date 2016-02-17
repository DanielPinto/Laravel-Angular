<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //

    protected $fillable = [

        'nome',
        'responsible',
        'email',
        'phone',
        'address',
        'obs'
    ];
}
