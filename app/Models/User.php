<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //The roles of user
    const ADMIN_ROLE_NAME = 'Admin';
    const USER_ROLE_NAME = 'User';

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        if ($this->role === self::ADMIN_ROLE_NAME) return true;

        return false;
    }

    /**
     * @return Relation
     */
    public function cars(): Relation
    {
        return $this->belongsToMany(Car::class, 'users_cars');
    }
}
