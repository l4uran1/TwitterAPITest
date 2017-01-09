<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model {
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    
    protected $fillable = ['call_to', 'method', 'path', 'username', 'count', 'json_result'];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [];
}

