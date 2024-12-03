@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Ulashilgan retseplar</h1>
        <p class="text-muted">Boshqa foydalanuvchilar tomonidan baham ko'rilgan retseptlarni o'rganing.</p>
    </div>

    @if ($sharedRecipes->isEmpty())
        <div class="text-center mt-5">
            <p class="text-muted">Hozircha umumiy retseptlar mavjud emas.</p>
        </div>
    @else
        <div class="row">
            @foreach ($sharedRecipes as $sharedRecipe)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <!-- Modal ochish uchun rasm -->
                        <img 
                            src="{{ $sharedRecipe->recipe->image_url ? asset('storage/' . $sharedRecipe->recipe->image_url) : 'https://via.placeholder.com/500x300' }}"  
                            class="card-img-top" 
                            alt="{{ $sharedRecipe->recipe->title }}" 
                            style="max-height: 200px; object-fit: cover; cursor: pointer;"
                            data-bs-toggle="modal" 
                            data-bs-target="#recipeModal-{{ $sharedRecipe->recipe->id }}"
                        >
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold">{{ $sharedRecipe->recipe->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($sharedRecipe->recipe->ingredients, 40, '...') }}</p>
                            <p class="card-text text-muted">{{ Str::limit($sharedRecipe->recipe->content, 40, '...') }}</p>
                            
                            <!-- Foydalanuvchining email manzili -->
                            <p class="text-secondary small">
                                <strong>Foydalanuvchi:</strong> {{ $sharedRecipe->recipe->user->email ?? 'No email available' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Modal for Viewing Full Recipe -->
                <div class="modal fade" id="recipeModal-{{ $sharedRecipe->recipe->id }}" tabindex="-1" aria-labelledby="recipeModalLabel-{{ $sharedRecipe->recipe->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="recipeModalLabel-{{ $sharedRecipe->recipe->id }}">{{ $sharedRecipe->recipe->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img 
                                            src="{{ $sharedRecipe->recipe->image_url ? asset('storage/' . $sharedRecipe->recipe->image_url) : 'https://via.placeholder.com/500x300' }}" 
                                            class="img-fluid" 
                                            alt="{{ $sharedRecipe->recipe->title }}"
                                            style="max-height: 300px; object-fit: cover; width: 100%;"
                                        >
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Ingredients:</h6>
                                        <p>{{ $sharedRecipe->recipe->ingredients }}</p>
                                        <h6 class="text-muted mt-3">Preparation Instructions:</h6>
                                        <p>{{ $sharedRecipe->recipe->content }}</p>
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
