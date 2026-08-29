<?php

namespace App\Models\Types;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EwalletType extends Model
{
    use HasFactory;
    protected $table = 'ewallet_type';
    protected $primaryKey = 'EWTID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
