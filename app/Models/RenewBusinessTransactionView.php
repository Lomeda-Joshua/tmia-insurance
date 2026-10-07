<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenewBusinessTransactionView extends Model
{
        protected $table = 'vw_transactions_rb';
        protected $primaryKey = 'Insurance_No';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false; 
}
