@extends('back.layouts.master')

@section('title', 'Home About Əlavə Et')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Home About Əlavə Et</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('back.pages.home-about.index') }}">Home About</a></li>
                            <li class="breadcrumb-item active">Əlavə Et</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('back.pages.home-about.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Image Upload Section -->
                            <div class="mb-4">
                                <label class="form-label">Şəkillər (302x362)</label>
                                <div id="images-container">
                                    <div class="mb-4 image-item">
                                        <div class="input-group mb-2">
                                            <input type="file" name="images[]" class="form-control" required>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger" onclick="removeImage(this)">Sil</button>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <label class="form-label">Alt Text (AZ)</label>
                                            <input type="text" name="images_alt_az[]" class="form-control" required>
                                            <label class="form-label mt-2">Alt Text (EN)</label>
                                            <input type="text" name="images_alt_en[]" class="form-control" required>
                                            <label class="form-label mt-2">Alt Text (RU)</label>
                                            <input type="text" name="images_alt_ru[]" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-warning mt-2" onclick="addImage()">Yeni Şəkil Əlavə Et</button>
                            </div>

                            <!-- Description Section -->
                            <div class="mb-3">
                                <label class="form-label">Açıqlama (AZ)</label>
                                <textarea name="description_az" class="form-control summernote @error('description_az') is-invalid @enderror" rows="3">{{ old('description_az') }}</textarea>
                                @error('description_az')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#az" role="tab">AZ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#en" role="tab">EN</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#ru" role="tab">RU</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3">
                                <!-- AZ Tab -->
                                <div class="tab-pane active" id="az" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label">Başlıq 1</label>
                                        <input type="text" name="title1_az" class="form-control @error('title1_az') is-invalid @enderror" required>
                                        @error('title1_az')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Başlıq 2</label>
                                        <input type="text" name="title2_az" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Xüsusi Başlıq 1</label>
                                        <input type="text" name="special_title1_az" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Xüsusi Başlıq 2</label>
                                        <input type="text" name="special_title2_az" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Xüsusi Başlıq 3</label>
                                        <input type="text" name="special_title3_az" class="form-control">
                                    </div>
                                </div>

                                <!-- EN Tab -->
                                <div class="tab-pane" id="en" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label">Title 1</label>
                                        <input type="text" name="title1_en" class="form-control @error('title1_en') is-invalid @enderror" required>
                                        @error('title1_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Title 2</label>
                                        <input type="text" name="title2_en" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Special Title 1</label>
                                        <input type="text" name="special_title1_en" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Special Title 2</label>
                                        <input type="text" name="special_title2_en" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Special Title 3</label>
                                        <input type="text" name="special_title3_en" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Açıqlama (EN)</label>
                                        <textarea name="description_en" class="form-control summernote @error('description_en') is-invalid @enderror" rows="3">{{ old('description_en') }}</textarea>
                                        @error('description_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- RU Tab -->
                                <div class="tab-pane" id="ru" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label">Заголовок 1</label>
                                        <input type="text" name="title1_ru" class="form-control @error('title1_ru') is-invalid @enderror" required>
                                        @error('title1_ru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Заголовок 2</label>
                                        <input type="text" name="title2_ru" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Специальный Заголовок 1</label>
                                        <input type="text" name="special_title1_ru" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Специальный Заголовок 2</label>
                                        <input type="text" name="special_title2_ru" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Специальный Заголовок 3</label>
                                        <input type="text" name="special_title3_ru" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Açıqlama (RU)</label>
                                        <textarea name="description_ru" class="form-control summernote @error('description_ru') is-invalid @enderror" rows="3">{{ old('description_ru') }}</textarea>
                                        @error('description_ru')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Yadda saxla</button>
                                    <a href="{{ route('back.pages.home-about.index') }}" class="btn btn-secondary">Ləğv et</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addImage() {
        const container = document.getElementById('images-container');
        
        // Create main image input group
        const wrapper = document.createElement('div');
        wrapper.className = 'mb-4 image-item';

        // Image input
        const imageGroup = document.createElement('div');
        imageGroup.className = 'input-group mb-2';
        
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'images[]';
        input.className = 'form-control';
        input.required = true;

        const buttonDiv = document.createElement('div');
        buttonDiv.className = 'input-group-append';

        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'btn btn-danger';
        button.onclick = function() { removeImage(this); };
        button.textContent = 'Sil';

        buttonDiv.appendChild(button);
        imageGroup.appendChild(input);
        imageGroup.appendChild(buttonDiv);

        // Alt text inputs
        const altTextsDiv = document.createElement('div');
        altTextsDiv.className = 'mt-2';

        // AZ
        const labelAz = document.createElement('label');
        labelAz.className = 'form-label';
        labelAz.textContent = 'Alt Text (AZ)';
        const inputAz = document.createElement('input');
        inputAz.type = 'text';
        inputAz.name = 'images_alt_az[]';
        inputAz.className = 'form-control';
        inputAz.required = true;

        // EN
        const labelEn = document.createElement('label');
        labelEn.className = 'form-label mt-2';
        labelEn.textContent = 'Alt Text (EN)';
        const inputEn = document.createElement('input');
        inputEn.type = 'text';
        inputEn.name = 'images_alt_en[]';
        inputEn.className = 'form-control';
        inputEn.required = true;

        // RU
        const labelRu = document.createElement('label');
        labelRu.className = 'form-label mt-2';
        labelRu.textContent = 'Alt Text (RU)';
        const inputRu = document.createElement('input');
        inputRu.type = 'text';
        inputRu.name = 'images_alt_ru[]';
        inputRu.className = 'form-control';
        inputRu.required = true;

        altTextsDiv.appendChild(labelAz);
        altTextsDiv.appendChild(inputAz);
        altTextsDiv.appendChild(labelEn);
        altTextsDiv.appendChild(inputEn);
        altTextsDiv.appendChild(labelRu);
        altTextsDiv.appendChild(inputRu);

        wrapper.appendChild(imageGroup);
        wrapper.appendChild(altTextsDiv);
        container.appendChild(wrapper);
    }

    function removeImage(button) {
        const wrapper = button.closest('.image-item');
        if (wrapper && document.querySelectorAll('.image-item').length > 1) {
            wrapper.remove();
        } else {
            alert('En az bir resim gereklidir!');
        }
    }
</script>

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush
@endsection
