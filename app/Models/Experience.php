<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'company',
        'position',
        'location',
        'start_date',
        'end_date',
        'current',
        'description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'current' => 'boolean',
        ];
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function highlights()
    {
        return $this->hasMany(ExperienceHighlight::class)->orderBy('sort_order');
    }
}
