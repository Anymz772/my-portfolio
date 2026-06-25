<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\VisitorStat;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class AnalyticsController extends Controller
{
    public function trackVisit(Request $request, $slug)
    {
        $portfolio = Portfolio::where('slug', $slug)->firstOrFail();

        $ip = $request->ip();
        $location = Location::get($ip);

        // Parse user agent for browser/platform detection
        $userAgent = $request->userAgent();
        $browser = $this->detectBrowser($userAgent);
        $platform = $this->detectPlatform($userAgent);
        $deviceType = $this->detectDeviceType($userAgent);

        VisitorStat::create([
            'portfolio_id' => $portfolio->id,
            'session_id' => $request->input('session_id', uniqid()),
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'referrer' => $request->input('referrer'),
            'path' => $request->input('path', '/'),
            'country' => $location?->countryName,
            'country_code' => $location?->countryCode,
            'region' => $location?->regionName,
            'city' => $location?->cityName,
            'latitude' => $location?->latitude,
            'longitude' => $location?->longitude,
            'browser' => $browser,
            'platform' => $platform,
            'device_type' => $deviceType,
            'visited_at' => now(),
        ]);

        return response()->json(['message' => 'Visit tracked']);
    }

    public function getStats()
    {
        $portfolio = auth()->user()->portfolio;

        $total = $portfolio->visitorStats()->count();
        $today = $portfolio->visitorStats()->whereDate('visited_at', today())->count();
        $thisWeek = $portfolio->visitorStats()
            ->whereBetween('visited_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        $thisMonth = $portfolio->visitorStats()
            ->whereBetween('visited_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        // Location breakdown
        $locations = $portfolio->visitorStats()
            ->selectRaw('country, city, COUNT(*) as count')
            ->whereNotNull('country')
            ->groupBy('country', 'city')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Daily visits for the last 7 days
        $dailyVisits = $portfolio->visitorStats()
            ->selectRaw('DATE(visited_at) as date, COUNT(*) as visits')
            ->whereBetween('visited_at', [now()->subDays(7), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Browser breakdown
        $browsers = $portfolio->visitorStats()
            ->selectRaw('browser, COUNT(*) as count')
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Referrer breakdown
        $referrers = $portfolio->visitorStats()
            ->selectRaw('referrer, COUNT(*) as count')
            ->groupBy('referrer')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return response()->json([
            'total' => $total,
            'today' => $today,
            'this_week' => $thisWeek,
            'this_month' => $thisMonth,
            'locations' => $locations,
            'daily_visits' => $dailyVisits,
            'browsers' => $browsers,
            'referrers' => $referrers,
        ]);
    }

    public function getAnalyticsConfig()
    {
        return response()->json(auth()->user()->portfolio->analytics);
    }

    public function updateAnalyticsConfig(Request $request)
    {
        $request->validate([
            'google_analytics_id' => ['sometimes', 'string', 'nullable'],
            'custom_scripts' => ['sometimes', 'array'],
        ]);

        $portfolio = auth()->user()->portfolio;
        $portfolio->update([
            'google_analytics_id' => $request->google_analytics_id,
            'custom_scripts' => $request->custom_scripts
                ? json_encode($request->custom_scripts)
                : null,
        ]);

        return response()->json($portfolio->analytics);
    }

    private function detectBrowser($userAgent)
    {
        if (strpos($userAgent, 'Edge') !== false || strpos($userAgent, 'Edg') !== false) return 'Edge';
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) return 'Opera';
        return 'Other';
    }

    private function detectPlatform($userAgent)
    {
        if (strpos($userAgent, 'Windows') !== false) return 'Windows';
        if (strpos($userAgent, 'Mac') !== false) return 'macOS';
        if (strpos($userAgent, 'Linux') !== false) return 'Linux';
        if (strpos($userAgent, 'iPhone') !== false) return 'iOS';
        if (strpos($userAgent, 'Android') !== false) return 'Android';
        return 'Other';
    }

    private function detectDeviceType($userAgent)
    {
        if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false || strpos($userAgent, 'iPhone') !== false) {
            return 'mobile';
        }
        if (strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'iPad') !== false) {
            return 'tablet';
        }
        return 'desktop';
    }
}
