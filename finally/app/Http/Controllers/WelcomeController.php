<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page with public recipes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch the latest public recipes (only non-private recipes)
        $recipes = Recipe::where('is_public', true)
            ->latest()
            ->take(9) // Limit to 9 recipes for the welcome page
            ->get();
    
        // Check if recipes are empty and set a flag
        $isEmpty = $recipes->isEmpty();
    
        return view('welcome', compact('recipes', 'isEmpty'));
    }
}
