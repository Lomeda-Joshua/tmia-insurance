<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileNbUpload extends Model
{
    use HasFactory;
    protected $table = 'file_nb_upload';
    protected $primaryKey = 'ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID',
        'Name',
        'Type',
        'Size',
        'File',
        'Date_Time',
        'Insurance_No',
    ];
}
