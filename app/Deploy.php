<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deploy extends Model
{
    protected $fillable = ['application_id', 'stage', 'sha1', 'username'];
}
