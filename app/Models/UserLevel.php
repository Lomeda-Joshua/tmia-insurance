<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLevel extends Model
{
    use HasFactory;

    protected $table = 'user_level';

    protected $primaryKey = 'User_Level_ID';

    protected $fillable = [
        'User_Level_ID',
        'User_Level_Description',
    ];


    public function users(){
        return $this->hasMany(User::class, 'User_Level_ID', 'User_Level_ID');
    }
}
