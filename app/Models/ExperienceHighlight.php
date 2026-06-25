<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceHighlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'experience_id',
        'text',
        'sort_order',
    ];

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
}
