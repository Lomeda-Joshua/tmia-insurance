<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CityMunicipal extends Model
{
    use HasFactory;
    protected $table = 'city_municipal';
    protected $primaryKey = 'CMCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'CMCode',
        'CityMunicipal',
        'PSGCode',
        'RegCode'
    ];
}
