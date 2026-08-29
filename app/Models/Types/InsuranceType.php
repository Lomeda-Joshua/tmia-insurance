<?php

namespace App\Models\Types;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsuranceType extends Model
{
    use HasFactory;
    protected $table = 'insurance_type';
    protected $primaryKey = 'Insurance_TID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
