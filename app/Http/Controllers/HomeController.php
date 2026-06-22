<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Inertia\Inertia; // ← Make sure this import exists!

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'profile' => Profile::first(),
            'skills' => Skill::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->groupBy('category'),
            'experiences' => Experience::where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
            'projects' => Project::where('published', true)
                ->orderBy('sort_order')
                ->limit(3)
                ->get(),
        ]);
    }
}
