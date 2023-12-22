<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, HasApiTokens, Notifiable;

    const ROLE_ADMIN = 0;
    const ROLE_MEMBER = 1;
    const ROLE_GUEST = 2;

    protected $table = "users";

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // You might also want to hide the password and remember token in the array representation of the model
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
   
}
