<?php

namespace App\Models\Types;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommunicationType extends Model
{
    use HasFactory;
    protected $table = 'communication_type';
    protected $primaryKey = 'Communication_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
