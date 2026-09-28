<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionRb extends Model
{
    protected $table = 'transactions_rb';
    protected $primaryKey = 'Insurance_No';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'Gross_Premium',
        'Net_Rem',
        'Net_Rem_Date',
        'Commission',
        'User_ID',
    ];
}
