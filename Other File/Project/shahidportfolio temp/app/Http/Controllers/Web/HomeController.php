<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\PortfolioCategory;
use App\Models\Portfolio\PortfolioItem;
use App\Models\Portfolio\PortfolioProfile;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $profile = PortfolioProfile::with([
            'socialLinks' => fn($query) => $query->where('is_active', true),
            'skills' => fn($query) => $query->where('is_active', true),
            'resumeSections.items' => fn($query) => $query->where('is_active', true)->orderBy('sort_order'),
            'contactInfos' => fn($query) => $query->where('is_active', true),
            'stats' => fn($query) => $query->where('is_active', true),
            'services' => fn($query) => $query->where('is_active', true),
            'testimonials' => fn($query) => $query->where('is_active', true),
        ])->first();

        $portfolioCategories = PortfolioCategory::where('is_active', true)->orderBy('sort_order')->get();
        $portfolioItems = PortfolioItem::with('category')->where('is_active', true)->orderBy('sort_order')->get();

        return view('web.pages.home.index', compact('profile', 'portfolioCategories', 'portfolioItems'));
    }
}
