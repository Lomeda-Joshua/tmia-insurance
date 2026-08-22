<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleInformation extends Model
{
    use HasFactory;

    protected $table = 'vehicle_information';

    protected $primaryKey = 'VIN';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;
}
