<?php

namespace App\Models\Types;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\VehicleInformation;

class BodyType extends Model
{
    use HasFactory;
    protected $table = 'body_type';
    protected $primaryKey = 'Body_TID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function vehicleInformation(){
        return $this->hasMany(VehicleInformation::class, "Body_TID", "Body_Type");
    }
}
