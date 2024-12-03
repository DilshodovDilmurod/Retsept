@extends('layouts.app') 
 
@section('content') 
<div class="container"> 
    <div class="row justify-content-center"> 
        <div class="col-md-8"> 
            <div class="card shadow-lg border-0"> 
                <div class="card-header text-center bg-primary text-white"> 
                    <h2 class="mb-0">Yangi retsept yaratish</h2> 
                </div> 
                <div class="card-body p-4"> 
                    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data"> 
                        @csrf 
 
                        <!-- Recipe Title --> 
                        <div class="form-group mb-4"> 
                            <label for="title" class="form-label fw-bold text-secondary">Retsept Nomi</label> 
                            <input  
                                type="text"  
                                name="title"  
                                id="title"  
                                class="form-control"  
                                placeholder="Retsept sarlavhasini kiriting"  
                                required> 
                        </div> 
 
                        <!-- Recipe Image --> 
                        <div class="form-group mb-4"> 
                            <label for="image" class="form-label fw-bold text-secondary">Ovqat rasmi</label> 
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
                            <label for="ingredients" class="form-label fw-bold text-secondary">Mahsulotlar</label> 
                            <textarea  
                                name="ingredients"  
                                id="ingredients"  
                                class="form-control"  
                                rows="3"  
                                placeholder="Mahsulotlarni vergul bilan ajratilgan holda kiriting"  
                                required></textarea> 
                        </div> 
 
                        <!-- Preparation Instructions --> 
                        <div class="form-group mb-4"> 
                            <label for="content" class="form-label fw-bold text-secondary">Tayyorlash bo'yicha ko'rsatma</label> 
                            <textarea  
                                name="content"  
                                id="content"  
                                class="form-control"  
                                rows="5"  
                                placeholder="Ushbu retseptni tayyorlash bosqichlarini tasvirlab bering"  
                                required></textarea> 
                        </div> 
 
                       <!-- Public Checkbox -->
                        <div class="form-check mb-4">
                           <!-- Default qiymat: agar radio tugmachalar tanlanmasa, "0" yuboriladi -->
<input type="hidden" name="is_public" value="0">

<!-- Public va Private uchun radio tugmalar -->
<div class="form-check">
    <input  
        type="radio"  
        name="is_public"  
        id="public"  
        class="form-check-input"  
        value="1"
        {{ old('is_public', $recipe->is_public ?? 0) == 1 ? 'checked' : '' }}> <!-- Public tanlangan holat -->
    <label for="public" class="form-check-label text-secondary">Ommaviy retsept</label>
</div>

<div class="form-check">
    <input  
        type="radio"  
        name="is_public"  
        id="private"  
        class="form-check-input"  
        value="0"
        {{ old('is_public', $recipe->is_public ?? 0) == 0 ? 'checked' : '' }}> <!-- Private tanlangan holat -->
    <label for="private" class="form-check-label text-secondary">Shaxsiy retsept</label>
</div>

                        </div>
                             
                        </div> 
 
                        <!-- Submit Button --> 
                        <button type="submit" class="btn btn-primary w-100"> 
                            <i class="bi bi-save2 me-2"></i>Retsept yaratish 
                        </button> 
                    </form> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> 
@endsection