<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionRBPayment extends Model
{
    use HasFactory;
    protected $table = 'transactions_rb_payment';
    public $timestamps = false;

    protected $fillable = [
        'Payment_ID',
        'Payment_Type',
        'EWallet_Type',
        'Payment_Terms',
        'Payment_Amount',
        'Payment_Date',
        'CC_No',
        'CC_Holder_Name',
        'CC_Expiry_Date',
        'CC_CVV',
        'PDC_No',
        'PDC_Account_Name',
        'PDC_Bank_Name',
        'PDC_Date',
        'Insurance_No',
        'User_ID',
    ];
}
