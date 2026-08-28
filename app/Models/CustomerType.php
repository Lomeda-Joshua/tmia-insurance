<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    use HasFactory;

    protected $table = 'customer_type';
    
    // Updated to match SQL primary key
    protected $primaryKey = 'Customer_TID'; 

    // Enable auto-incrementing if Customer_TID auto-increments (1, 2, 3, 4)
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'Customer_TID',
        'Customer_Type',
    ];
}