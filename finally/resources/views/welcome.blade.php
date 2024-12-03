@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Public Recipes</h1>

    @if ($recipes->isEmpty())
        <div class="text-center">
            <p class="text-muted">No recipes available.</p>
            <a href="{{ route('login') }}" class="btn btn-primary mx-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-secondary mx-2">Register</a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($recipes as $recipe)
                <div class="col-md-4">
                    <div class="card shadow-lg border-0">
                        <div class="card-img-wrapper position-relative">
                            <img 
                                src="{{ $recipe->image_url ?? 'https://via.placeholder.com/300x200' }}" 
                                class="card-img-top rounded-top" 
                                alt="{{ $recipe->title }}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#recipeModal{{ $recipe->id }}"
                                style="cursor: pointer;"
                            >
                            <div class="overlay text-center position-absolute top-50 start-50 translate-middle d-none" style="background: rgba(0, 0, 0, 0.5); color: #fff; width: 100%; height: 100%; z-index: 1;">
                                <p class="fw-bold">View Recipe</p>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title text-truncate">{{ $recipe->title }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="recipeModal{{ $recipe->id }}" tabindex="-1" aria-labelledby="recipeModalLabel{{ $recipe->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="recipeModalLabel{{ $recipe->id }}">{{ $recipe->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6 class="fw-bold">Ingredients:</h6>
                                <ul>
                                    @foreach (explode(',', $recipe->ingredients) as $ingredient)
                                        <li>{{ $ingredient }}</li>
                                    @endforeach
                                </ul>
                                <h6 class="fw-bold mt-3">Instructions:</h6>
                                <p>{{ $recipe->content }}</p>
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

<style>
    .card-img-wrapper:hover .overlay {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card:hover {
        transform: scale(1.03);
        transition: transform 0.3s ease-in-out;
    }
</style>
@endsection
