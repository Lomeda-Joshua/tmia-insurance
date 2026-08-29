<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UploadedCustomer extends Model
{
    use HasFactory;
    protected $table = 'upload_customer_data';
    protected $primaryKey = 'Customer_No';
    public $incrementing = false;
    protected $keyType = 'string';
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
        'VIN',
        'Make',
        'Model',
        'Model_Year',
        'Color',
        'Engine_No',
        'CS_No',
        'Plate_No',
        'Order_No',
        'Order_Status',
        'SRP',
        'VSI_Date',
        'Released_Date',
        'Technical_Date',
        'Model_Sales_Code',
        'Variant',
        'Body_Type',
        'Transmission',
        'Fuel_Type',
        'Seats',
        'Unloaded_Weight',
        'Max_Weight',
        'Prod_Classify',
        'Owner_Type',
        'Owner_Name',
        'MP_Name',
    ];
}
