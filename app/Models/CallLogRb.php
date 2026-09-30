<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallLogRb extends Model
{
    {
    // Bind to the database view
    protected $table = 'vw_call_logs_rb';

    // Primary key configuration
    protected $primaryKey = 'Call_LogID';

    // Views are read-only, so disable timestamps if not present
    public $timestamps = false;

    /**
     * Scope to fetch logs by Insurance Number ordered by latest first
     */
    public function scopeByInsuranceNo($query, string $insuranceNo)
    {
        return $query->where('Insurance_No', $insuranceNo)
                     ->orderBy('Call_LogID', 'desc');
    }
}
