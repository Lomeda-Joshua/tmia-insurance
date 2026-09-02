<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerInformation extends Model
{
    use HasFactory;

    protected $table = 'customer_information_copy';

    // Override the default 'id' primary key
    protected $primaryKey = 'Customer_No';

    // Specify primary key type if string (e.g. 'CUST-0001')
    public $incrementing = false;
    protected $keyType = 'string';

    // Views are read-only; disable timestamps
    public $timestamps = false;

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
        'Full_Address',
        'Upload_Cust_No',
        'NBCount',
        'RBCount',
        'Remarks',
        'Active_Status',
        'Inactive_Date'
    ];

    public function vehicle() : HasMany
    {
        return $this->HasMany(VehicleInformation::class, 'Customer_No', 'Customer_No');
    }


}
