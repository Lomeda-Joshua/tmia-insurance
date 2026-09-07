<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UploadedEdafCustomer extends Model
{
    use HasFactory;
    protected $table = 'vehicle_information_copy';
    protected $primaryKey = 'VIN';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
