<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable // implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'User_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'User_ID',
        'Last_Name',
        'First_Name',
        'Middle_Name',
        'Suffix_Name',
        'Display_Name',
        'User_Name',
        'Encrypt_Password',
        'Contact_No',
        'Email_Address',
        'User_Level_ID',
        'Register_Date',
        'Approved_Date',
        'Enable2FA',
        'Google2FAKey',
        'ExpireDate',
        'Log_Date',
        'Log_Time',
        'Active',
        'Dealer_ID'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'Register_Date' => 'date', // or 'datetime' if it includes a time component
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Override default password column name for authentication.
     */
    public function getAuthPassword(): string
    {
        return $this->Encrypt_Password;
    }
    
}
