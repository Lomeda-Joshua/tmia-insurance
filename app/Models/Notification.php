<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $primaryKey = 'ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [     
        "ID",
        "Insurance_No",
        "Business_Type",
        "Insurance_Status",
        "Title",
        "Message",
        "Info_Type",
        "URL",
        "Status",
        "Created_Date",
        "User_ID"
    ];

}

