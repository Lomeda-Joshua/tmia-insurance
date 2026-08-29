<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;
    protected $table = 'region';
    protected $primaryKey = 'RegCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
