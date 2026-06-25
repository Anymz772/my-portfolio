<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioSection;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function show($slug)
    {
        $portfolio = Portfolio::where('slug', $slug)
            ->with([
                'sections',
                'hero',
                'socialLinks',
                'about.highlights',
                'skills',
                'experiences.highlights',
                'projects.technologies',
                'education',
                'testimonials',
            ])
            ->firstOrFail();

        if ($portfolio->maintenance_mode) {
            return response()->json([
                'maintenance' => true,
                'message' => 'This portfolio is under maintenance.',
            ]);
        }

        return response()->json($this->formatPortfolio($portfolio));
    }

    public function myPortfolio()
    {
        $portfolio = auth()->user()->portfolio;

        if (!$portfolio) {
            return response()->json(['message' => 'Portfolio not found'], 404);
        }

        return response()->json($portfolio->load([
            'sections',
            'hero',
            'socialLinks',
            'about.highlights',
            'skills',
            'experiences.highlights',
            'projects.technologies',
            'education',
            'testimonials',
        ]));
    }

    public function update(Request $request)
    {
        $portfolio = auth()->user()->portfolio;

        $request->validate([
            'slug' => ['sometimes', 'string', 'unique:portfolios,slug,' . $portfolio->id],
            'template' => ['sometimes', 'string', 'in:modern,minimal,creative,professional'],
            'is_published' => ['sometimes', 'boolean'],
        ]);

        $portfolio->update($request->only(['slug', 'template', 'is_published']));

        return response()->json($portfolio);
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            'primary' => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'secondary' => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'accent' => ['required', 'string', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'mode' => ['required', 'in:light,dark'],
        ]);

        $portfolio = auth()->user()->portfolio;
        $portfolio->update([
            'primary_color' => $request->primary,
            'secondary_color' => $request->secondary,
            'accent_color' => $request->accent,
            'theme_mode' => $request->mode,
        ]);

        return response()->json($portfolio->theme);
    }

    public function updateSections(Request $request)
    {
        $request->validate([
            'sections' => ['required', 'array'],
        ]);

        $portfolio = auth()->user()->portfolio;

        foreach ($request->sections as $sectionName => $config) {
            PortfolioSection::where('portfolio_id', $portfolio->id)
                ->where('section_name', $sectionName)
                ->update([
                    'enabled' => $config['enabled'] ?? true,
                    'custom_title' => $config['title'] ?? null,
                ]);
        }

        return response()->json($portfolio->sections);
    }

    public function toggleMaintenance()
    {
        $portfolio = auth()->user()->portfolio;
        $portfolio->update([
            'maintenance_mode' => !$portfolio->maintenance_mode,
        ]);

        return response()->json([
            'maintenance_mode' => $portfolio->maintenance_mode,
        ]);
    }

    public function updateSEO(Request $request)
    {
        $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'max:500'],
            'keywords' => ['sometimes', 'array'],
            'og_image' => ['sometimes', 'string'],
        ]);

        $portfolio = auth()->user()->portfolio;
        $portfolio->update([
            'seo_title' => $request->title ?? $portfolio->seo_title,
            'seo_description' => $request->description ?? $portfolio->seo_description,
            'seo_keywords' => $request->keywords ? implode(',', $request->keywords) : $portfolio->seo_keywords,
            'og_image' => $request->og_image ?? $portfolio->og_image,
        ]);

        return response()->json($portfolio->seo);
    }

    private function formatPortfolio($portfolio)
    {
        return [
            'id' => $portfolio->id,
            'slug' => $portfolio->slug,
            'template' => $portfolio->template,
            'theme' => $portfolio->theme,
            'seo' => $portfolio->seo,
            'analytics' => $portfolio->analytics,
            'sections' => $portfolio->sections->pluck('enabled', 'section_name'),
            'hero' => $portfolio->hero,
            'social_links' => $portfolio->socialLinks,
            'about' => $portfolio->about,
            'skills' => $portfolio->skills,
            'experience' => $portfolio->experiences,
            'projects' => $portfolio->projects,
            'education' => $portfolio->education,
            'testimonials' => $portfolio->testimonials,
        ];
    }
}
