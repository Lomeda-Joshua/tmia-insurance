<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RenewalBusinessTransaction extends Model
{
    use HasFactory;
    protected $table = 'transactions_rb';
    protected $primaryKey = 'Insurance_No';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
