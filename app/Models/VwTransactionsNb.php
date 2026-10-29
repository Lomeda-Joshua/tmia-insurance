<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VwTransactionsNb extends Model
{
    use HasFactory;

    protected $table = 'vw_transactions_nb';

    protected $primarykey = 'Insurance_No';

    public function nbPaymentInfo(){
        return $this->hasMany(TransactionNBpayment::class, 'Insurance_No', 'Insurance_No');
    }
}
