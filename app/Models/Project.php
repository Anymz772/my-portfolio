<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'thumbnail', 'image_gallery',
        'tech_stack', 'project_url', 'github_url', 'published', 'sort_order',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    // Auto-generate slug
    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function getTechStackArrayAttribute()
    {
        return explode(',', $this->tech_stack ?? '');
    }
}
