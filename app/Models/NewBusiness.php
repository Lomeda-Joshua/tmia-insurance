<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewBusiness extends Model
{
    protected $table = "transactions_nb";

    protected $fillable = [
        'Insurance_No',
        'Gross_Premium',
        'Net_Rem',
        'Net_Rem_Date',
        'Commission',
        'Option_Type',
        'Install_Pay',
        'Month_Terms',
        'Month_Pay',
        'Insurance_Type',
        'Insurance_Company',
        'Start_Date',
        'Policy_No',
        'Issue_Date',
        'Policy_Expiration',
        'Mortgage',
        'Customer_No',
        'VIN',
        'Trans_Status',
        'Trans_Status_Remarks',
        'Trans_Status_Date',
        'Trans_Date',
        'ISE_No',
        'User_ID'
    ];
}
