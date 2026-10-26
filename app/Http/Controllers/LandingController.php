<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Display the official Nazelle Délices landing page.
     */
    public function index(): View
    {
        $featuredProducts = Product::with('category')
            ->where('stock', '>', 0)
            ->take(6)
            ->get();

        return view('landing.index', compact('featuredProducts'));
    }
}
