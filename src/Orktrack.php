<?php

namespace Opnuc\OpnucOrktrack;

use Illuminate\Database\Eloquent\Model;

class Orktrack extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'timestamp'];
}