@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center bg-primary text-white">
                    <h2 class="mb-0">Create New Recipe</h2>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Recipe Title -->
                        <div class="form-group mb-4">
                            <label for="title" class="form-label fw-bold text-secondary">Recipe Title</label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                class="form-control" 
                                placeholder="Enter recipe title" 
                                required>
                        </div>

                        <!-- Recipe Image -->
                        <div class="form-group mb-4">
                            <label for="image" class="form-label fw-bold text-secondary">Recipe Image</label>
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                class="form-control" 
                                accept="image/*" 
                                required>
                        </div>

                        <!-- Ingredients -->
                        <div class="form-group mb-4">
                            <label for="ingredients" class="form-label fw-bold text-secondary">Ingredients (comma-separated)</label>
                            <textarea 
                                name="ingredients" 
                                id="ingredients" 
                                class="form-control" 
                                rows="3" 
                                placeholder="Enter ingredients, separated by commas" 
                                required></textarea>
                        </div>

                        <!-- Preparation Instructions -->
                        <div class="form-group mb-4">
                            <label for="content" class="form-label fw-bold text-secondary">Preparation Instructions</label>
                            <textarea 
                                name="content" 
                                id="content" 
                                class="form-control" 
                                rows="5" 
                                placeholder="Describe the steps to prepare this recipe" 
                                required></textarea>
                        </div>

                        <!-- Public Checkbox -->
                        <div class="form-check mb-4">
                        <input type="hidden" name="is_public" value="0"> <!-- Default qiymat -->
                        <input 
                            type="checkbox" 
                            name="is_public" 
                            id="is_public" 
                            class="form-check-input" 
                            value="1">
                        <label for="is_public" class="form-check-label text-secondary">Make this recipe public</label>
                            
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save2 me-2"></i>Create Recipe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
