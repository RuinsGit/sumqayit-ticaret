@extends('back.layouts.master')

@section('title', 'Hero Düzənlə')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Hero Düzənlə</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('back.pages.store-hero.index') }}">Hero</a></li>
                            <li class="breadcrumb-item active">Düzənlə</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('back.pages.store-hero.update', $storeHero->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="image" class="form-label">Mövcud Şəkil:</label>
                                <div class="current-image-container">
                                    <div class="image-preview">
                                        <img src="{{ asset($storeHero->image) }}" 
                                             alt="{{ $storeHero->image_alt_az }}" 
                                             class="preview-img">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Yeni Şəkil:</label>
                                <input type="file" class="form-control" name="image" accept=".jpeg,.png,.jpg,.gif,.svg">
                            </div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#az" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">AZ</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#en" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">EN</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#ru" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">RU</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <!-- Az tab -->
                                <div class="tab-pane active" id="az" role="tabpanel">
                                    <div class="mb-3">
                                        <label for="title_az" class="form-label">Başlıq (AZ):</label>
                                        <input type="text" class="form-control" name="title_az" value="{{ old('title_az', $storeHero->title_az) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description_az" class="form-label">Təsvir (AZ):</label>
                                        <textarea class="form-control" name="description_az" rows="4" required>{{ old('description_az', $storeHero->description_az) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image_alt_az" class="form-label">Şəkil Alt (AZ):</label>
                                        <input type="text" class="form-control" name="image_alt_az" value="{{ old('image_alt_az', $storeHero->image_alt_az) }}" required>
                                    </div>
                                </div>

                                <!-- En tab -->
                                <div class="tab-pane" id="en" role="tabpanel">
                                    <div class="mb-3">
                                        <label for="title_en" class="form-label">Başlıq (EN):</label>
                                        <input type="text" class="form-control" name="title_en" value="{{ old('title_en', $storeHero->title_en) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description_en" class="form-label">Təsvir (EN):</label>
                                        <textarea class="form-control" name="description_en" rows="4" required>{{ old('description_en', $storeHero->description_en) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image_alt_en" class="form-label">Şəkil Alt (EN):</label>
                                        <input type="text" class="form-control" name="image_alt_en" value="{{ old('image_alt_en', $storeHero->image_alt_en) }}" required>
                                    </div>
                                </div>

                                <!-- Ru tab -->
                                <div class="tab-pane" id="ru" role="tabpanel">
                                    <div class="mb-3">
                                        <label for="title_ru" class="form-label">Başlıq (RU):</label>
                                        <input type="text" class="form-control" name="title_ru" value="{{ old('title_ru', $storeHero->title_ru) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description_ru" class="form-label">Təsvir (RU):</label>
                                        <textarea class="form-control" name="description_ru" rows="4" required>{{ old('description_ru', $storeHero->description_ru) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image_alt_ru" class="form-label">Şəkil Alt (RU):</label>
                                        <input type="text" class="form-control" name="image_alt_ru" value="{{ old('image_alt_ru', $storeHero->image_alt_ru) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Yadda saxla</button>
                                    <a href="{{ route('back.pages.store-hero.index') }}" class="btn btn-secondary">Ləğv et</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.current-image-container {
    margin: 15px 0;
}

.image-preview {
    width: 300px;
    height: 200px;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin: 0 auto;
}

.preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.3s ease;
}

.image-preview:hover .preview-img {
    transform: scale(1.05);
}

.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
    border-radius: 12px;
    overflow: hidden;
}

.nav-tabs {
    border-bottom: 2px solid #eee;
    margin-bottom: 20px;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 12px 20px;
    transition: all 0.2s ease;
}

.nav-tabs .nav-link.active {
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    background: transparent;
}

.nav-tabs .nav-link:hover {
    border-color: transparent;
    color: #3498db;
}

.form-label {
    font-weight: 500;
    color: #2c3e50;
    margin-bottom: 8px;
}

.form-control {
    border-radius: 6px;
    border: 1px solid #dee2e6;
    padding: 8px 12px;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.2s ease;
    border-radius: 6px;
}

.btn-primary {
    background-color: #3498db;
    border-color: #3498db;
}

.btn-primary:hover {
    background-color: #2980b9;
    border-color: #2980b9;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-secondary {
    background-color: #95a5a6;
    border-color: #95a5a6;
}

.btn-secondary:hover {
    background-color: #7f8c8d;
    border-color: #7f8c8d;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.tab-content {
    padding: 20px;
    background-color: #fff;
    border-radius: 0 0 8px 8px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .image-preview {
        width: 200px;
        height: 150px;
    }
    
    .nav-tabs .nav-link {
        padding: 8px 12px;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>
@endsection 