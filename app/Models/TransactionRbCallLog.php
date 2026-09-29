<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionRbCallLog extends Model
{
    protected $table = 'transactions_rb_call_logs';
    protected $primaryKey = 'Call_logID';
    public $timestamps = false;

    // Relationships
/*     public function communicationType()
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
    } */
}
