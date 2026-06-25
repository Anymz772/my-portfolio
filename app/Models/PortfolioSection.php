<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'section_name',
        'enabled',
        'custom_title',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
        ];
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
