@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Public Recipes</h1>
        <p class="text-muted">Explore delicious recipes shared by the community.</p>
    </div>

    @if ($recipes->isEmpty())
        <div class="text-center mt-5">
            <p class="text-muted">No public recipes available yet.</p>
            <a href="{{ route('login') }}" class="btn btn-primary mx-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-secondary mx-2">Register</a>
        </div>
    @else
        <div class="row">
            @foreach ($recipes as $recipe)
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
