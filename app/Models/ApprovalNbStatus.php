<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalNbStatus extends Model
{
    protected $table = 'approval_nb_status';
    public $timestamps = false;

    protected $fillable = [
        'Insurance_No',
        'User_ID',
        'Trans_Status',
        'Trans_Status_Remarks',
        'Trans_Status_Date',
    ];
}
