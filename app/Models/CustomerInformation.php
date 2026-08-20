<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInformation extends Model
{
    protected $table = 'customer_information';

    protected $fillable = [
        'Customer_No',
        'Group',
        'Full_Name',
        'First_Name',
        'Middle_Name',
        'Last_Name',
        'Suffix_Name',
        'Birth_Date',
        'TIN',
        'Contact_No',
        'Email_Address',
        'Address',
        'RegCode',
        'ProvCode',
        'CMCode',
        'BrgyCode',
        'Zip_Code',
        'Country',
        'Upload_Cust_No',
        'Remarks',
        'Active_Status',
        'Inactive_Date'
    ];


}
