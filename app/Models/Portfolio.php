<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'template',
        'is_published',
        'maintenance_mode',
        'primary_color',
        'secondary_color',
        'accent_color',
        'theme_mode',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_image',
        'google_analytics_id',
        'custom_scripts',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'maintenance_mode' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()
    {
        return $this->hasMany(PortfolioSection::class);
    }

    public function hero()
    {
        return $this->hasOne(HeroSection::class);
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class)->orderBy('sort_order');
    }

    public function about()
    {
        return $this->hasOne(AboutSection::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class)->orderBy('sort_order');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class)->orderBy('sort_order');
    }

    public function projects()
    {
        return $this->hasMany(Project::class)->orderBy('sort_order');
    }

    public function education()
    {
        return $this->hasMany(Education::class)->orderBy('sort_order');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class)->orderBy('sort_order');
    }

    public function visitorStats()
    {
        return $this->hasMany(VisitorStat::class);
    }

    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function getThemeAttribute()
    {
        return [
            'primary' => $this->primary_color,
            'secondary' => $this->secondary_color,
            'accent' => $this->accent_color,
            'mode' => $this->theme_mode,
            'background' => $this->theme_mode === 'dark' ? '#0f172a' : '#ffffff',
            'text' => $this->theme_mode === 'dark' ? '#f1f5f9' : '#1f2937',
        ];
    }

    public function getSeoAttribute()
    {
        return [
            'title' => $this->seo_title,
            'description' => $this->seo_description,
            'keywords' => $this->seo_keywords ? explode(',', $this->seo_keywords) : [],
            'og_image' => $this->og_image,
        ];
    }

    public function getAnalyticsAttribute()
    {
        return [
            'google_analytics_id' => $this->google_analytics_id,
            'custom_scripts' => $this->custom_scripts ? json_decode($this->custom_scripts, true) : [],
        ];
    }
}
