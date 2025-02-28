@extends('back.layouts.master')

@section('title', 'Xidməti Redaktə Et')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Xidməti Redaktə Et</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('back.pages.services.index') }}">Xidmətlər</a></li>
                                <li class="breadcrumb-item active">Redaktə</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('back.pages.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

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
                                            <label class="form-label">Başlıq (AZ)</label>
                                            <input type="text" name="title_az" class="form-control" value="{{ old('title_az', $service->title_az) }}">
                                            @error('title_az')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mətn (AZ)</label>
                                            <textarea name="description_az" class="form-control summernote">{{ old('description_az', $service->description_az) }}</textarea>
                                            @error('description_az')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- En tab -->
                                    <div class="tab-pane" id="en" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Title (EN)</label>
                                            <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $service->title_en) }}">
                                            @error('title_en')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description (EN)</label>
                                            <textarea name="description_en" class="form-control summernote">{{ old('description_en', $service->description_en) }}</textarea>
                                            @error('description_en')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Ru tab -->
                                    <div class="tab-pane" id="ru" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Заголовок (RU)</label>
                                            <input type="text" name="title_ru" class="form-control" value="{{ old('title_ru', $service->title_ru) }}">
                                            @error('title_ru')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Текст (RU)</label>
                                            <textarea name="description_ru" class="form-control summernote">{{ old('description_ru', $service->description_ru) }}</textarea>
                                            @error('description_ru')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Üst Şəkil (700x740)</label>
                                        @if($service->image)
                                            <div class="mb-2">
                                                <img src="{{ asset($service->image) }}" alt="Current Image" class="img-thumbnail" style="max-height: 150px">
                                            </div>
                                        @endif
                                        <input type="file" name="image" class="form-control">
                                        @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <label class="form-label">Alt Şəkil</label>
                                        @if($service->bottom_image)
                                            <div class="mb-2">
                                                <img src="{{ asset($service->bottom_image) }}" alt="Current Bottom Image" class="img-thumbnail" style="max-height: 150px">
                                            </div>
                                        @endif
                                        <input type="file" name="bottom_image" class="form-control">
                                        @error('bottom_image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div> -->
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Yadda saxla</button>
                                        <a href="{{ route('back.pages.services.index') }}" class="btn btn-secondary">Ləğv et</a>
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

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $(".summernote").summernote();
        $('.dropdown-toggle').dropdown();
    });
</script>
@endpush