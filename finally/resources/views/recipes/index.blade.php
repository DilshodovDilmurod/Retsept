@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container">
    <h1>Public Recipes</h1>
    @forelse ($publicRecipes as $recipe)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $recipe->title }}</h5>
                <p class="card-text">{{ $recipe->content }}</p>
                <p class="text-muted">By: {{ $recipe->user->name }}</p>
            </div>
        </div>
    @empty
        <p>No public recipes available.</p>
    @endforelse
</div>
@endsection
