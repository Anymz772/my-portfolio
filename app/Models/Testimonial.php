<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'name',
        'position',
        'company',
        'content',
        'avatar',
        'sort_order',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
