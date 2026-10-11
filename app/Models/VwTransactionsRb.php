<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VwTransactionsRb extends Model
{
    use HasFactory;

    protected $table = 'vw_transactions_rb';

    protected $primarykey = 'Insurance_No';

    public function rbPaymentInfo(){
        return $this->hasMany(TransactionRBPayment::class, 'Insurance_No', 'Insurance_No');
    }

}
