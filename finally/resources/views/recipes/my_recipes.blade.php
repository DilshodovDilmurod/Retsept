@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1 class="fw-bold">My Recipes</h1>
        <p class="text-muted">Manage your personal recipes and share them with friends.</p>
    </div>

    @if ($myRecipes->isEmpty())
        <div class="text-center mt-5">
            <p class="text-muted">You have no recipes yet.</p>
            <a href="{{ route('recipes.create') }}" class="btn btn-success">Create Your First Recipe</a>
        </div>
    @else
        <div class="row">
            @foreach ($myRecipes as $recipe)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <!-- Recipe Image with Modal Trigger -->
                       <img 
                       src="{{ $recipe->image_url ? asset('storage/' . $recipe->image_url) : 'https://via.placeholder.com/500x300' }}"  
                        class="card-img-top" 
                        alt="{{ $recipe->title }}" 
                        style="max-height: 200px; object-fit: cover;"
                        data-bs-toggle="modal" 
                        data-bs-target="#recipeModal-{{ $recipe->id }}"
                    >

                        <!-- Recipe Details -->
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold">{{ $recipe->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($recipe->content, 100, '...') }}</p>
                           
                            <!-- Share Form -->
                            <form action="{{ route('recipes.share', $recipe) }}" method="POST" class="mt-3">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="email-{{ $recipe->id }}" class="form-label">Share with:</label>
                                    <input type="email" name="email" id="email-{{ $recipe->id }}" class="form-control" placeholder="Enter email address" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Share</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal for Viewing Full Recipe -->
                <div class="modal fade" id="recipeModal-{{ $recipe->id }}" tabindex="-1" aria-labelledby="recipeModalLabel-{{ $recipe->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="recipeModalLabel-{{ $recipe->id }}">{{ $recipe->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <div class="col-md-6">
                                    <img 
                                        src="{{ $recipe->image_url ? asset('storage/' . $recipe->image_url) : 'https://via.placeholder.com/500x300' }}" 
                                        class="img-fluid" 
                                        alt="{{ $recipe->title }}"
                                        style="max-height: 300px; object-fit: cover; width: 100%;"
                                    >
                                </div>

                                    <div class="col-md-6">
                                        <h6 class="text-muted">Ingredients:</h6>
                                        <p>{{ $recipe->ingredients }}</p>
                                        <h6 class="text-muted mt-3">Preparation Instructions:</h6>
                                        <p>{{ $recipe->instructions }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
