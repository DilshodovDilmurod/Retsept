<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class RecipeController extends Controller
{

    public function index()
    {
        // Fetch public recipes
        $publicRecipes = Recipe::where('is_public', true)->get();
    
        // Check if the user is authenticated
        $myRecipes = auth()->check() ? auth()->user()->recipes : collect();
    
        return view('recipes.index', compact('publicRecipes', 'myRecipes'));
    }
    
    public function create()
    {
        return view('recipes.create');
    }
    
    public function store(Request $request)
{
    
    // 1. Validatsiya
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'required|image|max:2048',
        'ingredients' => 'required|string',
        'content' => 'required|string',
        'is_public' => 'nullable|boolean', // Checkbox maydoni
    ]);

    // 2. Suratni saqlash
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('recipes/images', 'public'); // Suratni "public" papkaga saqlash
    } else {
        return back()->with('error', 'Image upload failed.');
    }

    // 3. Yangi Recipe modelini yaratish va ma'lumotlarni to‘ldirish
    $recipe = new Recipe();
    $recipe->title = $validated['title'];
    $recipe->image_url = $imagePath; // Fayl yo'li bazaga saqlanadi
    $recipe->ingredients = $validated['ingredients'];
    $recipe->content = $validated['content'];
    $recipe->is_public = $request->has('is_public') ? 1 : 0; // Checkbox qiymati
    $recipe->user_id = auth()->id(); // Hozirgi foydalanuvchi ID'si (Agar `user_id` ustuni mavjud bo'lsa)
    
    // 4. Saqlash
    if ($recipe->save()) {
        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully!');
    } else {
        return back()->with('error', 'Failed to save the recipe.');
    }
}

    
    public function share(Request $request, Recipe $recipe)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);
    
        $user = User::where('email', $data['email'])->firstOrFail();
    
        if ($user->id === auth()->id()) {
            return back()->withErrors(['email' => 'You cannot share a recipe with yourself.']);
        }
    
        // Sharing functionality (e.g., notify user or create access record)
        $user->sharedRecipes()->attach($recipe);
    
        return back()->with('success', 'Recipe shared successfully.');
    }
    public function myRecipes()
    {
        // Foydalanuvchini olish
        $user = auth()->user();

        // Agar foydalanuvchi autentifikatsiya qilinmagan bo‘lsa, login sahifasiga yo‘naltirish
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view this page.');
        }

        // Foydalanuvchining barcha retseptlarini olish
        $myRecipes = auth()->user()->recipes;

        // Sahifaga retseptlarni uzatish
        return view('recipes.my_recipes', compact('myRecipes'));
    } 

    
}
