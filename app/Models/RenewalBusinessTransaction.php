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

    protected $fillable = [
        "Insurance_No",
        "Gross_Premium",
        "Net_Rem",
        "Net_Rem_Date",
        "Commission",
        "Option_Type",
        "Install_Pay",
        "Month_Terms",
        "Month_Pay",
        "Insurance_Type",
        "Insurance_Company",
        "Start_Date",
        "Policy_No",
        "Issue_Date",
        "Policy_Expiration",
        "Mortgage",
        "Policy_Action",
        "Previous_InsCompany",
        "Customer_No",
        "VIN",
        "Trans_Status",
        "Trans_Status_Remarks",
        "Trans_Status_Date",
        "Trans_Date",
        "ISE_No",
        "User_ID",
    ];

    public function customer_details (){
        return $this->belongsTo(CustomerInformation::class, "Customer_No" , "Customer_No");
    }
}
