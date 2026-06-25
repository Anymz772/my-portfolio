<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_section_id',
        'text',
        'sort_order',
    ];

    public function aboutSection()
    {
        return $this->belongsTo(AboutSection::class);
    }
}
