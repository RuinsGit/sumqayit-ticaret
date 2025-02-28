@extends('back.layouts.master')

@section('title', 'Yeni Hero Əlavə Et')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Yeni Hero Əlavə Et</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('back.pages.store-hero.index') }}">Hero</a></li>
                            <li class="breadcrumb-item active">Yeni</li>
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

                        <form action="{{ route('back.pages.store-hero.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="image" class="form-label">Şəkil (1440x480):</label>
                                <input type="file" class="form-control" name="image" accept=".jpeg,.png,.jpg,.gif,.svg" required>
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
                                        <input type="text" class="form-control" name="title_az" value="{{ old('title_az') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description_az" class="form-label">Təsvir (AZ):</label>
                                        <textarea class="form-control" name="description_az" rows="4" required>{{ old('description_az') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image_alt_az" class="form-label">Şəkil Alt (AZ):</label>
                                        <input type="text" class="form-control" name="image_alt_az" value="{{ old('image_alt_az') }}" required>
                                    </div>
                                </div>

                                <!-- En tab -->
                                <div class="tab-pane" id="en" role="tabpanel">
                                    <div class="mb-3">
                                        <label for="title_en" class="form-label">Başlıq (EN):</label>
                                        <input type="text" class="form-control" name="title_en" value="{{ old('title_en') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description_en" class="form-label">Təsvir (EN):</label>
                                        <textarea class="form-control" name="description_en" rows="4" required>{{ old('description_en') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image_alt_en" class="form-label">Şəkil Alt (EN):</label>
                                        <input type="text" class="form-control" name="image_alt_en" value="{{ old('image_alt_en') }}" required>
                                    </div>
                                </div>

                                <!-- Ru tab -->
                                <div class="tab-pane" id="ru" role="tabpanel">
                                    <div class="mb-3">
                                        <label for="title_ru" class="form-label">Başlıq (RU):</label>
                                        <input type="text" class="form-control" name="title_ru" value="{{ old('title_ru') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description_ru" class="form-label">Təsvir (RU):</label>
                                        <textarea class="form-control" name="description_ru" rows="4" required>{{ old('description_ru') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image_alt_ru" class="form-label">Şəkil Alt (RU):</label>
                                        <input type="text" class="form-control" name="image_alt_ru" value="{{ old('image_alt_ru') }}" required>
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
@endsection 