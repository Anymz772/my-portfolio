<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'session_id',
        'ip_address',
        'user_agent',
        'referrer',
        'path',
        'country',
        'country_code',
        'region',
        'city',
        'latitude',
        'longitude',
        'browser',
        'platform',
        'device_type',
        'visited_at',
    ];

    protected function casts(): array
    {
        return [
            'visited_at' => 'date',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
