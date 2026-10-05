<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionRb extends Model
{
    use HasFactory;

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

    public function insurance_agent() : BelongsTo
    {
        return $this->belongsTo(InsuranceStaff::class, "ISE_No", "ISE_No");
    }

    public function customer_information(){
        return $this->belongsTo(CustomerInformation::class,'Customer_No', 'Customer_No');
    }

    public function transaction_Rb_payment(){
        return $this->hasMany(TransactionRBPayment::class,'Insurance_No','Insurance_No' );
    }
}
