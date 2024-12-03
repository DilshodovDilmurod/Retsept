@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Barcha Retseplar</h1>
        <p class="text-muted">Hamjamiyatimiz tomonidan baham ko'rilgan mazali retseptlar to'plamini o'rganing.</p>
    </div>

    <!-- Qidiruv qismi -->
    <div class="d-flex justify-content-center mb-5">
        <div class="search-box">
            <input 
                type="text" 
                id="search" 
                class="form-control search-input" 
                placeholder="🔍 Retseptlarni qidirish..." 
                autocomplete="off"
            >
        </div>
    </div>

    @if ($publicRecipes->isEmpty())
        <div class="text-center mt-5">
            <p class="text-muted">Hech qanday retsept topilmadi.</p>
        </div>
    @else
        <div class="row" id="recipe-container">
            @foreach ($publicRecipes as $recipe)
                <div 
                    class="col-md-4 mb-4 recipe-item" 
                    data-title="{{ strtolower($recipe->title) }}"
                >
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
                            <p class="card-text text-muted">{{ Str::limit($recipe->ingredients, 40, '...') }}</p>
                            <p class="card-text text-muted">{{ Str::limit($recipe->content, 40, '...') }}</p>
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
                                        <h6 class="text-muted">Mahsulotlar:</h6>
                                        <p>{{ $recipe->ingredients }}</p>
                                        <h6 class="text-muted mt-3">Tayyorlash bo'yicha ko'rsatma:</h6>
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

<style>
    /* Qidiruv maydoni uchun uslublar */
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
        border-color: #007bff; /* Primary rang */
        box-shadow: 0 6px 10px rgba(0, 123, 255, 0.2);
    }
</style>
@endsection
