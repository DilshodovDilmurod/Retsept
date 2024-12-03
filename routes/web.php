<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.delete');

// Shared Recipes sahifasi
Route::get('/recipes/shared', [RecipesController::class, 'sharedWithMe'])->name('recipes.shared');

Route::middleware('auth')->group(function () {
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::post('/recipes/share', [RecipeController::class, 'share'])->name('recipes.shared');

});


// Public Recipes
Route::get('/', [RecipeController::class, 'index'])->name('recipes.index');

// My Recipes
Route::get('/recipes/my', [RecipeController::class, 'myRecipes'])->name('recipes.my')->middleware('auth');

// Create Recipe
Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create')->middleware('auth');
Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store')->middleware('auth');

// Share Recipe
Route::post('/recipes/{recipe}/share', [RecipeController::class, 'share'])->name('recipes.share')->middleware('auth');

// edit recipe
Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');

Route::resource('recipes', RecipeController::class);

// Shared Recipes sahifasi
Route::post('/recipesshare', [RecipeController::class, 'share'])->name('recipes.shared');

// Route::get('/shared', function(){
//     return view("shared");
// });

Route::get('/sharedonce', [RecipeController::class, "sharedWithMe"])->name('shared');




require __DIR__.'/auth.php';
