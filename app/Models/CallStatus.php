<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class CallStatus extends Model
{
    use HasFactory;
    protected $table = 'call_status_type';
    protected $primaryKey = 'Call_SID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
