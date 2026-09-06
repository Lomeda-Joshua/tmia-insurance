<?php

namespace App\Models\Types;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class PaymentType extends Model
{
    use HasFactory;
    protected $table = 'payment_type';
    protected $primaryKey = 'PayTID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
