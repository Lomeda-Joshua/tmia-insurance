<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VwCallLogsRb extends Model
{
    // Define view name
    protected $table = 'vw_call_logs_rb';

    // Primary key setting (if applicable)
    protected $primaryKey = 'Call_LogID';

    // Disable automatic timestamps as database views don't manage created_at/updated_at
    public $timestamps = false;
}
