<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionRbCallLog extends Model
{
    protected $table = 'transactions_rb_call_logs';
    protected $primaryKey = 'Call_logID';
    public $timestamps = false;

    protected $fillable = [
        'Insurance_No',
        'Communication_ID',
        'Call_SID',
        'Reason_ID',
        'Promised_Pay_Date',
        'Call_Remarks',
        'Call_Log_Date',
        'User_ID',
    ];

    protected $casts = [
        'Call_Log_Date' => 'datetime',
        'Promised_Pay_Date' => 'date',
    ];

    // Relationships
    public function communicationType()
    {
        return $this->belongsTo(CommunicationType::class, 'Communication_ID', 'Communication_ID');
    }

    public function callStatus()
    {
        return $this->belongsTo(CallStatusType::class, 'Call_SID', 'Call_SID');
    }

    public function callReason()
    {
        return $this->belongsTo(CallReason::class, 'Reason_ID', 'Reason_ID');
    }
}
