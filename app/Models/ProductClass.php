<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductClass extends Model
{
    use HasFactory;
    protected $table = 'product_classification';
    protected $primaryKey = 'Prod_Class_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
