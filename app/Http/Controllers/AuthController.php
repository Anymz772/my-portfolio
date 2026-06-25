<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Portfolio;
use App\Models\PortfolioSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create default portfolio for user
        $slug = $this->generateSlug($user->name);
        $portfolio = Portfolio::create([
            'user_id' => $user->id,
            'slug' => $slug,
            'template' => 'modern',
            'seo_title' => "{$user->name} - Portfolio",
            'seo_description' => "Professional portfolio of {$user->name}",
        ]);

        // Create default sections
        $defaultSections = ['hero', 'about', 'skills', 'experience', 'projects', 'education', 'contact', 'testimonials'];
        foreach ($defaultSections as $index => $section) {
            PortfolioSection::create([
                'portfolio_id' => $portfolio->id,
                'section_name' => $section,
                'enabled' => !in_array($section, ['testimonials']),
                'sort_order' => $index,
            ]);
        }

        // Create default hero section
        $portfolio->hero()->create([
            'title' => $user->name,
            'subtitle' => 'Professional',
            'description' => 'Welcome to my portfolio.',
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'user' => $user->load('portfolio'),
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'token' => $token,
            'user' => auth()->user()->load('portfolio'),
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        return response()->json(auth()->user()->load('portfolio'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'avatar' => ['sometimes', 'string'],
        ]);

        $user = auth()->user();
        $user->update($request->only(['name', 'email', 'avatar']));

        return response()->json($user);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Password updated successfully']);
    }

    private function generateSlug($name)
    {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $name));
        $slug = trim($slug, '-');
        $count = Portfolio::where('slug', 'like', "{$slug}%")->count();
        return $count > 0 ? "{$slug}-{$count}" : $slug;
    }
}
