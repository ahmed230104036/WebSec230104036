<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'credit'
    ];

    protected $hidden = [
        'password',
    ];

    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function isEmployee()
    {
        return $this->role === 'Employee';
    }

    public function isCustomer()
    {
        return $this->role === 'Customer';
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}


