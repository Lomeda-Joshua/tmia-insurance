<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barangay extends Model
{
    use HasFactory;
    protected $table = 'barangay';
    protected $primaryKey = 'BrgyCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'BrgyCode',
        'Barangay',
        'PSGCode',
        'CMCode'
    ];
}
