<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\SocialLink;
use App\Models\AboutSection;
use App\Models\Highlight;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\ExperienceHighlight;
use App\Models\Project;
use App\Models\ProjectTechnology;
use App\Models\Education;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    // Hero Section
    public function getHero()
    {
        return response()->json(auth()->user()->portfolio->hero);
    }

    public function updateHero(Request $request)
    {
        $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'subtitle' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'background_image' => ['sometimes', 'string'],
            'resume_url' => ['sometimes', 'string'],
        ]);

        $hero = auth()->user()->portfolio->hero;
        $hero->update($request->only([
            'title', 'subtitle', 'description', 'background_image', 'resume_url'
        ]));

        return response()->json($hero);
    }

    // Social Links
    public function addSocialLink(Request $request)
    {
        $request->validate([
            'platform' => ['required', 'string'],
            'url' => ['required', 'string', 'url'],
            'icon' => ['sometimes', 'string'],
        ]);

        $portfolio = auth()->user()->portfolio;
        $link = $portfolio->socialLinks()->create($request->all());

        return response()->json($link, 201);
    }

    public function deleteSocialLink($id)
    {
        auth()->user()->portfolio->socialLinks()->findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // About Section
    public function getAbout()
    {
        return response()->json(auth()->user()->portfolio->about->load('highlights'));
    }

    public function updateAbout(Request $request)
    {
        $request->validate([
            'bio' => ['sometimes', 'string'],
            'profile_image' => ['sometimes', 'string'],
            'location' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email'],
            'phone' => ['sometimes', 'string'],
        ]);

        $about = auth()->user()->portfolio->about;
        $about->update($request->only([
            'bio', 'profile_image', 'location', 'email', 'phone'
        ]));

        return response()->json($about->load('highlights'));
    }

    // Skills
    public function getSkills()
    {
        return response()->json(auth()->user()->portfolio->skills);
    }

    public function addSkill(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'min:0', 'max:100'],
            'icon' => ['sometimes', 'string'],
        ]);

        $portfolio = auth()->user()->portfolio;
        $skill = $portfolio->skills()->create($request->all());

        return response()->json($skill, 201);
    }

    public function updateSkill(Request $request, $id)
    {
        $skill = auth()->user()->portfolio->skills()->findOrFail($id);
        $skill->update($request->only(['name', 'category', 'level', 'icon']));

        return response()->json($skill);
    }

    public function deleteSkill($id)
    {
        auth()->user()->portfolio->skills()->findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // Experience
    public function getExperience()
    {
        return response()->json(auth()->user()->portfolio->experiences->load('highlights'));
    }

    public function addExperience(Request $request)
    {
        $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['sometimes', 'date'],
            'current' => ['sometimes', 'boolean'],
            'description' => ['sometimes', 'string'],
            'highlights' => ['sometimes', 'array'],
        ]);

        $portfolio = auth()->user()->portfolio;
        $experience = $portfolio->experiences()->create($request->except('highlights'));

        if ($request->has('highlights')) {
            foreach ($request->highlights as $index => $highlight) {
                $experience->highlights()->create([
                    'text' => $highlight,
                    'sort_order' => $index,
                ]);
            }
        }

        return response()->json($experience->load('highlights'), 201);
    }

    public function updateExperience(Request $request, $id)
    {
        $experience = auth()->user()->portfolio->experiences()->findOrFail($id);
        $experience->update($request->only([
            'company', 'position', 'location', 'start_date', 'end_date',
            'current', 'description'
        ]));

        return response()->json($experience->load('highlights'));
    }

    public function deleteExperience($id)
    {
        auth()->user()->portfolio->experiences()->findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // Projects
    public function getProjects()
    {
        return response()->json(auth()->user()->portfolio->projects->load('technologies'));
    }

    public function addProject(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['sometimes', 'string'],
            'live_url' => ['sometimes', 'string', 'url'],
            'source_url' => ['sometimes', 'string', 'url'],
            'featured' => ['sometimes', 'boolean'],
            'technologies' => ['sometimes', 'array'],
        ]);

        $portfolio = auth()->user()->portfolio;
        $project = $portfolio->projects()->create($request->except('technologies'));

        if ($request->has('technologies')) {
            foreach ($request->technologies as $index => $tech) {
                $project->technologies()->create([
                    'name' => is_string($tech) ? $tech : $tech['name'],
                    'sort_order' => $index,
                ]);
            }
        }

        return response()->json($project->load('technologies'), 201);
    }

    public function updateProject(Request $request, $id)
    {
        $project = auth()->user()->portfolio->projects()->findOrFail($id);
        $project->update($request->only([
            'title', 'description', 'image', 'live_url', 'source_url', 'featured'
        ]));

        return response()->json($project->load('technologies'));
    }

    public function deleteProject($id)
    {
        auth()->user()->portfolio->projects()->findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // Education
    public function getEducation()
    {
        return response()->json(auth()->user()->portfolio->education);
    }

    public function addEducation(Request $request)
    {
        $request->validate([
            'institution' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'field' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['sometimes', 'date'],
            'description' => ['sometimes', 'string'],
        ]);

        $portfolio = auth()->user()->portfolio;
        $education = $portfolio->education()->create($request->all());

        return response()->json($education, 201);
    }

    public function updateEducation(Request $request, $id)
    {
        $education = auth()->user()->portfolio->education()->findOrFail($id);
        $education->update($request->only([
            'institution', 'degree', 'field', 'start_date', 'end_date', 'description'
        ]));

        return response()->json($education);
    }

    public function deleteEducation($id)
    {
        auth()->user()->portfolio->education()->findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // Testimonials
    public function getTestimonials()
    {
        return response()->json(auth()->user()->portfolio->testimonials);
    }

    public function addTestimonial(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'avatar' => ['sometimes', 'string'],
        ]);

        $portfolio = auth()->user()->portfolio;
        $testimonial = $portfolio->testimonials()->create($request->all());

        return response()->json($testimonial, 201);
    }

    public function updateTestimonial(Request $request, $id)
    {
        $testimonial = auth()->user()->portfolio->testimonials()->findOrFail($id);
        $testimonial->update($request->only(['name', 'position', 'company', 'content', 'avatar']));

        return response()->json($testimonial);
    }

    public function deleteTestimonial($id)
    {
        auth()->user()->portfolio->testimonials()->findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
