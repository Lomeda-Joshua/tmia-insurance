<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionStatus extends Model
{
    use HasFactory;
    protected $table = 'transaction_status';
    protected $primaryKey = 'Trans_SID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
