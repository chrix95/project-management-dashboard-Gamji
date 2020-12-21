<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'dob', 'employee_code', 'branch_id', 'role', 'guarantor_name', 'guarantor_phone', 'guarantor_address', 'next_of_kin_name', 'next_of_kin_phone', 'means_of_identification', 'employment_letter'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects () {
        return $this->hasMany(Project::class);
    }
    public function requistion () {
        return $this->hasMany(Requistion::class);
    }
    public function branch () {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
    public function userDocument () {
        return $this->hasMany(UserDocument::class);
    }
}
