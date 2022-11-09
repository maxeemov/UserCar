<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Car extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return Relation
     */
    public function users(): Relation
    {
        return $this->belongsToMany(User::class, 'users_cars');
    }
}
