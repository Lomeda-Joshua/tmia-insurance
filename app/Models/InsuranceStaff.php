<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsuranceStaff extends Model
{
    use HasFactory;
    
    protected $table = 'vw_insurance_staff';

    protected $primaryKey = 'ISE_No';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;
}
