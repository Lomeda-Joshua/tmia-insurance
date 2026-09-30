<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallReason extends Model
{
    protected $table = 'call_reason';
    protected $primaryKey = 'Reason_ID';
    public $timestamps = false;

    protected $fillable = [
        'Call_SID',
        'Reason_Desc',
    ];
}
