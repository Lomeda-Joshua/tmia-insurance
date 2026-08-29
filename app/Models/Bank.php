<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Bank extends Model
{
    use HasFactory;
    protected $table = 'banks';
    protected $primaryKey = 'BankID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
