<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallStatusType extends Model
{
    protected $table = 'call_status_type';
    protected $primaryKey = 'Call_SID';
    public $timestamps = false;
}
