<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleInformation extends Model
{
    use HasFactory;

    protected $table = 'vehicle_information';

    protected $primaryKey = 'VIN';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'VIN', 
        'Make', 'Model', 'Model_Year', 'Color', 'Engine_No', 
        'CS_No', 'Plate_No', 'SRP', 'VSI_Date', 'Released_Date', 
        'Technical_Date', 'Variant', 'Body_Type', 'Transmission', 
        'Fuel_Type', 'Seats', 'Prod_Classify', 'Owner_Type', 
        'Owner_Name', 'MP_Name', 'Customer_No'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerInformation::class, 'Customer_No', 'Customer_No');
    }
}
