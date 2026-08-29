<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class InsuranceCo extends Model
{
    use HasFactory;
    protected $table = 'insurance_co';
    protected $primaryKey = 'Insurance_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
