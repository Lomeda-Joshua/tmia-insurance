<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserView extends Model
{
    protected $table = 'vw_users';
    protected $primaryKey = 'User_ID';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    
}
