<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'token_view',
        'files_count',
        'status',
        'ai_percentage',
        'plag_percentage',
        'claimed_by',
        'due_at',
        'delivered_at',
        'is_downloaded'
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'delivered_at' => 'datetime',
        'is_downloaded' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function files()
    {
        return $this->hasMany(OrderFile::class);
    }

    public function report()
    {
        return $this->hasOne(OrderReport::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'claimed_by');
    }

    public function getComputedStatusAttribute()
    {
        if ($this->status !== 'delivered' && now()->gt($this->due_at)) {
            return 'overdue';
        }
        return $this->status;
    }
}
