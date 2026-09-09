<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionNBpayment extends Model
{
    use HasFactory;
    protected $table = 'transactions_nb_payment';
    public $timestamps = false;

    protected $fillable = [
        'Insurance_No', 'User_ID', 'Payment_Type', 'EWallet_Type', 
        'PDC_No', 'PDC_Account_Name', 'PDC_Bank_Name', 'PDC_Date', 
        'Payment_Terms', 'Payment_Amount', 'Payment_Date'
    ];

}
