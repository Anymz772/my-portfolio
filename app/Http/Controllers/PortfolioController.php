<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function index()
    {
        return Inertia::render('Portfolio/Index', [
            'projects' => Project::where('published', true)
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function show(Project $project)
    {
        return Inertia::render('Portfolio/Show', [
            'project' => $project,
            'next' => Project::where('published', true)
                ->where('sort_order', '>', $project->sort_order)
                ->first(),
            'previous' => Project::where('published', true)
                ->where('sort_order', '<', $project->sort_order)
                ->orderBy('sort_order', 'desc')
                ->first(),
        ]);
    }
}
