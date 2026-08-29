<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BodyType extends Model
{
    use HasFactory;
    protected $table = 'body_type';
    protected $primaryKey = 'Body_TID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
