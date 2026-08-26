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

    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerInformation::class, 'Customer_No', 'Customer_No');
    }
}
