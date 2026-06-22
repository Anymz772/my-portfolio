<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run()
    {
        // Create Profile
        Profile::create([
            'full_name' => 'Muhammad Aiman Hakim',
            'role_title' => 'Full Stack Software Engineer',
            'email' => 'aiman@example.com',
            'phone' => '+60 12-345 6789',
            'bio' => 'Passionate software engineer specializing in Laravel, Inertia, React, and modern web systems development.',
            'github_url' => 'https://github.com/m-aiman',
            'linkedin_url' => 'https://linkedin.com/in/m-aiman',
        ]);

        // Create Skills
        $skills = [
            ['name' => 'Laravel', 'category' => 'Backend', 'percentage' => 95],
            ['name' => 'React', 'category' => 'Frontend', 'percentage' => 90],
            ['name' => 'Inertia.js', 'category' => 'Frontend', 'percentage' => 92],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'percentage' => 95],
            ['name' => 'PostgreSQL / MySQL', 'category' => 'Database', 'percentage' => 88],
            ['name' => 'Docker', 'category' => 'DevOps', 'percentage' => 75],
        ];

        foreach ($skills as $index => $skill) {
            Skill::create(array_merge($skill, ['sort_order' => $index]));
        }

        // Create Experiences
        $experiences = [
            [
                'company' => 'Premium Land Group (PLGS)',
                'role' => 'Senior Full Stack Developer',
                'location' => 'Kuala Lumpur',
                'start_date' => '2022-01-01',
                'description' => 'Developed charting systems and workflow automation platforms using Laravel and modern database designs.',
                'sort_order' => 1,
            ],
            [
                'company' => 'Creative Tech Agency',
                'role' => 'Web Developer',
                'location' => 'Remote',
                'start_date' => '2020-06-01',
                'end_date' => '2021-12-31',
                'description' => 'Built high-performance websites and custom customer relationship systems for various clients.',
                'sort_order' => 2,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::create($exp);
        }

        // Create Projects
        Project::create([
            'title' => 'Land Charting System (PLGS)',
            'slug' => 'land-charting-system-plgs',
            'description' => 'A workflow automation platform for land surveyors and administrators to manage land charting, application plans, and geometric lot overlays.',
            'tech_stack' => 'Laravel,PostgreSQL,Tailwind CSS,Alpine.js',
            'github_url' => 'https://github.com/m-aiman/plgs-charting',
            'published' => true,
            'sort_order' => 1,
        ]);

        Project::create([
            'title' => 'Interactive Developer Portfolio',
            'slug' => 'interactive-developer-portfolio',
            'description' => 'A premium personal portfolio website showcasing capabilities, experience, and custom design built using React, Inertia, and Tailwind CSS.',
            'tech_stack' => 'Laravel,Inertia.js,React,Tailwind CSS,Framer Motion',
            'github_url' => 'https://github.com/m-aiman/my-portfolio',
            'published' => true,
            'sort_order' => 2,
        ]);
    }
}
