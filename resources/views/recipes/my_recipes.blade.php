@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Mening retseptlarim</h1>
        <p class="text-muted">Shaxsiy retseptlaringizni boshqaring va ularni do'stlaringiz bilan baham ko'ring.</p>
    </div>

    <!-- Qidiruv qismi -->
    <div class="d-flex justify-content-center mb-4">
        <div class="search-box">
            <input 
                type="text" 
                id="search" 
                class="form-control search-input" 
                placeholder="🔍 Retseptlaringizni qidiring..." 
                autocomplete="off"
            >
        </div>
    </div>

    @if (session('success')) 
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert"> 
        <strong>Success!</strong> {{ session('success') }} 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> 
    </div> 
    @endif 
        
    @if (session('error')) 
        <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert"> 
            <strong>Error!</strong> {{ session('error') }} 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> 
        </div> 
    @endif

    @if ($myRecipes->isEmpty())
        <div class="text-center mt-5">
            <p class="text-muted">Sizda hali retsept yo'q.</p>
            <a href="{{ route('recipes.create') }}" class="btn btn-success">Birinchi retseptingizni yarating</a>
        </div>
    @else
        <div class="row" id="recipe-container">
            @foreach ($myRecipes as $recipe)
                <div 
                    class="col-md-4 mb-4 recipe-item" 
                    data-title="{{ strtolower($recipe->title) }}"
                >
                    <div class="card shadow-sm">
                        <img 
                            src="{{ $recipe->image_url ? asset('storage/' . $recipe->image_url) : 'https://via.placeholder.com/500x300' }}"  
                            class="card-img-top" 
                            alt="{{ $recipe->title }}" 
                            style="max-height: 200px; object-fit: cover;"
                            data-bs-toggle="modal" 
                            data-bs-target="#recipeModal-{{ $recipe->id }}"
                        >
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold">{{ $recipe->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($recipe->ingredients, 40, '...') }}</p>
                            <p class="card-text text-muted">{{ Str::limit($recipe->content, 40, '...') }}</p>
                            <div class="d-flex justify-content-between">
                                <!-- Share Form -->
                                <form action="{{ route('recipes.share', $recipe) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#shareModal-{{ $recipe->id }}">Share</button>
                                </form>
                                <!-- edit -->
                                <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <!-- delete -->
                                <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this recipe?')">Delete</button>
                                </form>
                            </div>
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
                                        <p>{{ $recipe->content }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- Share Modal -->
                 <div class="modal fade" id="shareModal-{{ $recipe->id }}" tabindex="-1" aria-labelledby="shareModalLabel-{{ $recipe->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="shareModalLabel-{{ $recipe->id }}">Share Recipe: {{ $recipe->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form action="{{ route('recipes.shared') }}" method="POST">
                                    @csrf
                                    <!-- Recipe ID -->
                                    <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">

                                    <!-- Email Input -->
                                    <div class="mb-3">
                                        <label for="email-{{ $recipe->id }}" class="form-label">Share With (User Email)</label>
                                        <input type="email" class="form-control" id="email-{{ $recipe->id }}" name="email" required placeholder="Enter user email">
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Share</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            @endforeach
        </div>
    @endif
</div>

<!-- Qidiruv Scripti -->
<script>
    document.getElementById("search").addEventListener("input", function () {
        const query = this.value.toLowerCase().trim();
        const recipeItems = document.querySelectorAll(".recipe-item");

        recipeItems.forEach(item => {
            const title = item.getAttribute("data-title");
            if (title.includes(query)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });
</script>
<script>
    // Success alertni yashirish
    setTimeout(function() {
        let successAlert = document.getElementById('success-alert');
        if (successAlert) {
            // successAlert.classList.remove('show');
            // successAlert.classList.add('fade');
            successAlert.remove();
        }
    }, 3000); // 5000 ms (5 sekund) davomida ko'rsatiladi

    // Error alertni yashirish
    setTimeout(function() {
        let errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            errorAlert.classList.remove('show');
            errorAlert.classList.add('fade');
        }
    }, 5000); // 2000 ms (5 sekund) davomida ko'rsatiladi
</script>

<style>
    .search-box {
        max-width: 600px;
        width: 100%;
    }

    .search-input {
        border: 2px solid #ddd;
        border-radius: 30px;
        padding: 12px 20px;
        font-size: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 6px 10px rgba(0, 123, 255, 0.2);
    }
</style>
@endsection
