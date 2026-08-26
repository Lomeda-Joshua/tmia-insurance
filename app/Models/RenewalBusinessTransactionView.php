<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RenewalBusinessTransactionView extends Model
{
    use HasFactory;
    
    protected $table = 'vw_transactions_rb';
    protected $primaryKey = 'Insurance_No';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
