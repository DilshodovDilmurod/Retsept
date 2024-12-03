<?php

namespace App\Http\Controllers;

use App\Models\Recipe; // Recipe modelini import qilish
use App\Models\User;
use App\Models\SharedRecipe;    // User modelini import qilish (foydalanuvchini topish uchun)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Mail sinfini import qilish
 // RecipeShared mактубini import qilish
use Illuminate\Support\Facades\DB;


class RecipeController extends Controller
{

    public function index(Request $request)
    {
        // Fetch public recipes
        $publicRecipes = Recipe::where('is_public', true)->get();
    
        // Check if the user is authenticated
        $myRecipes = auth()->check() ? auth()->user()->recipes : collect();

        // $publicRecipes = $query->get();
        
    
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
            'is_public' => 'required|boolean', // Radio tugmalar qiymati (public yoki private)
        ]);

        // 2. Suratni saqlash
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes/images', 'public'); // Suratni "public" papkaga saqlash
        } else {
            return back()->with('error', 'Surat yuklashda xatolik yuz berdi.');
        }

        // 3. Yangi Recipe modelini yaratish va ma'lumotlarni to‘ldirish
        $recipe = new Recipe();
        $recipe->title = $validated['title'];
        $recipe->image_url = $imagePath; // Fayl yo'li bazaga saqlanadi
        $recipe->ingredients = $validated['ingredients'];
        $recipe->content = $validated['content'];
        $recipe->is_public = $validated['is_public']; // Radio tugmadan olingan qiymat (1 yoki 0)
        $recipe->user_id = auth()->id(); // Hozirgi foydalanuvchi ID'si (Agar user_id ustuni mavjud bo'lsa)

        // 4. Saqlash
        if ($recipe->save()) {
            return redirect()->route('recipes.index')->with('success', 'Retsept muvaffaqiyatli yaratildi!');
        } else {
            return back()->with('error', 'Retseptni saqlashda xatolik yuz berdi.');
        }

    }
    
    public function share(Request $request)
    {
        // Validate the request
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'email' => 'required|email|exists:users,email', // Email foydalanuvchilar jadvalida bo'lishi kerak
        ]);
    
        // Retrieve the user to share with
        $sharedWithUser = User::where('email', $request->email)->firstOrFail();
    
        // Check if already shared
        $alreadyShared = SharedRecipe::where('recipe_id', $request->recipe_id)
                                     ->where('shared_with_user_id', $sharedWithUser->id)
                                     ->exists();
    
        if ($alreadyShared) {
            return back()->with('error', 'This recipe has already been shared with this user.');
        }
    
        // Save shared recipe
        SharedRecipe::create([
            'recipe_id' => $request->recipe_id,
            'shared_by_user_id' => auth()->id(), // Current user
            'shared_with_user_id' => $sharedWithUser->id,
        ]);
    
        return back()->with('success', 'Recipe shared successfully!');
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

    public function edit($id)
    {
        $recipe = Recipe::findOrFail($id); // Id bo‘yicha retseptni topish
        return view('recipes.edit', compact('recipe')); // Edit blade-ni qaytarish
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id); // Retseptni id orqali topish
        $recipe->delete(); // Retseptni o'chirish
        return redirect()->route('recipes.my')->with('success', 'Recipe deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        // Retseptni id orqali topish
        $recipe = Recipe::findOrFail($id);

        // Formadan kelgan ma'lumotlarni validatsiya qilish
        $request->validate([
            'title' => 'required|string|max:255',
            'ingredients' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Retsept ma'lumotlarini yangilash
        $recipe->title = $request->input('title');
        $recipe->ingredients = $request->input('ingredients');
        $recipe->content = $request->input('content');

        // Agar yangi rasm yuklangan bo'lsa
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
            $recipe->image_url = $imagePath;
        }

        // O'zgarishlarni saqlash
        $recipe->save();

        // Foydalanuvchini retseptlar ro'yxatiga qaytarish
        return redirect()->route('recipes.my')->with('success', 'Recipe updated successfully.');
    }

    public function sharedWithMe()
{
    $sharedRecipes = SharedRecipe::where('shared_with_user_id', auth()->id())
                                 ->with('recipe')
                                 ->get();

    return view('recipes.shared', compact('sharedRecipes'));
}

    

    
}
