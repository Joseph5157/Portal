<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'slots', 'plan_expiry', 'status'];

    protected $casts = [
        'plan_expiry' => 'datetime',
    ];

    public function links()
    {
        return $this->hasMany(ClientLink::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
