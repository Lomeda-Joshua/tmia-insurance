<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewBusinessTransactionView extends Model
{
        protected $table = 'vw_transactions_nb';
        protected $primaryKey = 'Insurance_No';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false; 
}
