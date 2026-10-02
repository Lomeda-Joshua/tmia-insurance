<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalRbStatus extends Model
{
    protected $table = 'approval_rb_status';
    public $timestamps = false;

    protected $fillable = [
        'Insurance_No',
        'User_ID',
        'Trans_Status',
        'Trans_Status_Remarks',
        'Trans_Status_Date',
    ];
}
