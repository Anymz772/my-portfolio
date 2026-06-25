<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'bio',
        'profile_image',
        'location',
        'email',
        'phone',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function highlights()
    {
        return $this->hasMany(Highlight::class)->orderBy('sort_order');
    }
}
