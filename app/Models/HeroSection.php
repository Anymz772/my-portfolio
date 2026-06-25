<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'title',
        'subtitle',
        'description',
        'background_image',
        'resume_url',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
