@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-center fw-bold text-primary">
                    Edit Recipe
                </div>
                <div class="card-body">
                    <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Retsept Nomi</label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                class="form-control" 
                                value="{{ old('title', $recipe->title) }}" 
                                required 
                                placeholder="Retsept sarlavhasini kiriting"
                            >
                        </div>

                        <!-- Ingredients -->
                        <div class="form-group mb-3">
                            <label for="ingredients" class="form-label">Mahsulotlar</label>
                            <textarea 
                                name="ingredients" 
                                id="ingredients" 
                                class="form-control" 
                                rows="3" 
                                required 
                                placeholder="Mahsulotlarni vergul bilan ajratilgan holda kiriting">{{ old('ingredients', $recipe->ingredients) }}</textarea>
                        </div>

                        <!-- Instructions -->
                        <div class="form-group mb-3">
                            <label for="instructions" class="form-label">Tayyorlash bo'yicha ko'rsatma</label>
                            <textarea 
                                name="content" 
                                id="content" 
                                class="form-control" 
                                rows="3" 
                                required 
                                placeholder="Ushbu retseptni tayyorlash bosqichlarini tasvirlab bering">{{ old('content', $recipe->content) }}</textarea>
                        </div>

                        <!-- Image -->
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Taom rasmi</label>
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                class="form-control"
                                accept="image/*"
                            >
                            @if ($recipe->image_url)
                                <div class="mt-2">
                                    <p class="text-muted">Joriy rasm:</p>
                                    <img 
                                        src="{{ asset('storage/' . $recipe->image_url) }}" 
                                        alt="{{ $recipe->title }}" 
                                        class="img-fluid" 
                                        style="max-height: 200px; object-fit: cover;"
                                    >
                                </div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Retseptni yangilash</button>
                            <a href="{{ route('recipes.index') }}" class="btn btn-secondary">Bekor qilish</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
