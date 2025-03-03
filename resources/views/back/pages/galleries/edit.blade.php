@extends('back.layouts.master')

@section('title', 'Qalereya Redaktə')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Qalereya Redaktə</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('back.pages.galleries.index') }}">Qalereya</a></li>
                                <li class="breadcrumb-item active">Redaktə</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <form action="{{ route('back.pages.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Images Section -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Şəkillər</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Main Image -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Əsas Şəkil (320x360)</label>
                                            <input type="file" name="main_image" class="form-control @error('main_image') is-invalid @enderror">
                                            @error('main_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if($gallery->main_image)
                                                <div class="mt-2 position-relative">
                                                    <img src="{{ asset('storage/' . $gallery->main_image) }}" 
                                                         alt="{{ $gallery->main_image_alt_az }}"
                                                         class="img-thumbnail"
                                                         style="max-height: 150px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Bottom Image -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Alt Şəkil (1280x500)</label>
                                            <input type="file" name="bottom_image" class="form-control @error('bottom_image') is-invalid @enderror">
                                            @error('bottom_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if($gallery->bottom_image)
                                                <div class="mt-2 position-relative">
                                                    <img src="{{ asset('storage/' . $gallery->bottom_image) }}" 
                                                         alt="{{ $gallery->bottom_image_alt_az }}"
                                                         class="img-thumbnail"
                                                         style="max-height: 150px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Additional Images -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Əlavə Şəkillər (413x320)</label>
                                            <input type="file" name="bottom_images[]" class="form-control mb-2" multiple>
                                            @if($gallery->multiple_images)
                                                <div class="mt-2">
                                                    <div class="row g-2">
                                                        @foreach($gallery->multiple_images as $key => $image)
                                                            <div class="col-12 position-relative mb-3">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset('storage/' . $image['image']) }}" 
                                                                         alt="{{ $image['alt_az'] }}"
                                                                         class="img-thumbnail me-2"
                                                                         style="height: 80px;">
                                                                    <div class="flex-grow-1">
                                                                        <div class="row g-1">
                                                                            <div class="col-md-4">
                                                                                <!-- <input type="text" 
                                                                                       name="existing_images_alt_az[]" 
                                                                                       class="form-control form-control-sm" 
                                                                                       value="{{ $image['alt_az'] }}" 
                                                                                       placeholder="AZ ALT"> -->
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <!-- <input type="text" 
                                                                                       name="existing_images_alt_en[]" 
                                                                                       class="form-control form-control-sm" 
                                                                                       value="{{ $image['alt_en'] }}" 
                                                                                       placeholder="EN ALT"> -->
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <!-- <input type="text" 
                                                                                       name="existing_images_alt_ru[]" 
                                                                                       class="form-control form-control-sm" 
                                                                                       value="{{ $image['alt_ru'] }}" 
                                                                                       placeholder="RU ALT"> -->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="existing_images[]" value="{{ $image['image'] }}">
                                                                    <button type="button" 
                                                                            class="btn btn-danger btn-sm ms-2"
                                                                            onclick="removeImage(this)">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            <button type="button" class="btn btn-soft-primary btn-sm mt-2" onclick="addImageInput()">
                                                <i class="ri-add-line"></i> Yeni Şəkil Əlavə Et
                                            </button>
                                            <div id="additional-images-container">
                                                <!-- New image inputs will be added here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#az" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">AZ</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#en" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">EN</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#ru" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">RU</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- AZ Tab -->
                                    <div class="tab-pane active" id="az" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Başlıq</label>
                                            <input type="text" name="title_az" id="title_az" class="form-control @error('title_az') is-invalid @enderror" value="{{ old('title_az', $gallery->title_az) }}" required>
                                            @error('title_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                            <input type="text" name="slug_az" id="slug_az" class="form-control @error('slug_az') is-invalid @enderror" value="{{ old('slug_az', $gallery->slug_az) }}">
                                            @error('slug_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mətn</label>
                                            <textarea name="description_az" class="form-control @error('description_az') is-invalid @enderror" rows="4" required>{{ old('description_az', $gallery->description_az) }}</textarea>
                                            @error('description_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- <div class="mb-3">
                                            <label class="form-label">Əsas Şəkil ALT</label>
                                            <input type="text" name="main_image_alt_az" class="form-control @error('main_image_alt_az') is-invalid @enderror" value="{{ old('main_image_alt_az', $gallery->main_image_alt_az) }}" required>
                                            @error('main_image_alt_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Alt Şəkil ALT</label>
                                            <input type="text" name="bottom_image_alt_az" class="form-control @error('bottom_image_alt_az') is-invalid @enderror" value="{{ old('bottom_image_alt_az', $gallery->bottom_image_alt_az) }}" required>
                                            @error('bottom_image_alt_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Meta Başlıq</label>
                                            <input type="text" name="meta_title_az" class="form-control" value="{{ old('meta_title_az', $gallery->meta_title_az) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Meta Açıqlama</label>
                                            <textarea name="meta_description_az" class="form-control" rows="3">{{ old('meta_description_az', $gallery->meta_description_az) }}</textarea>
                                        </div> -->
                                    </div>

                                    <!-- EN Tab -->
                                    <div class="tab-pane" id="en" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="title_en" id="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en', $gallery->title_en) }}" required>
                                            @error('title_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                            <input type="text" name="slug_en" id="slug_en" class="form-control @error('slug_en') is-invalid @enderror" value="{{ old('slug_en', $gallery->slug_en) }}">
                                            @error('slug_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" rows="4" required>{{ old('description_en', $gallery->description_en) }}</textarea>
                                            @error('description_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- <div class="mb-3">
                                            <label class="form-label">Main Image ALT</label>
                                            <input type="text" name="main_image_alt_en" class="form-control @error('main_image_alt_en') is-invalid @enderror" value="{{ old('main_image_alt_en', $gallery->main_image_alt_en) }}" required>
                                            @error('main_image_alt_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Bottom Image ALT</label>
                                            <input type="text" name="bottom_image_alt_en" class="form-control @error('bottom_image_alt_en') is-invalid @enderror" value="{{ old('bottom_image_alt_en', $gallery->bottom_image_alt_en) }}" required>
                                            @error('bottom_image_alt_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Meta Title</label>
                                            <input type="text" name="meta_title_en" class="form-control" value="{{ old('meta_title_en', $gallery->meta_title_en) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Meta Description</label>
                                            <textarea name="meta_description_en" class="form-control" rows="3">{{ old('meta_description_en', $gallery->meta_description_en) }}</textarea>
                                        </div> -->
                                    </div>

                                    <!-- RU Tab -->
                                    <div class="tab-pane" id="ru" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Заголовок</label>
                                            <input type="text" name="title_ru" id="title_ru" class="form-control @error('title_ru') is-invalid @enderror" value="{{ old('title_ru', $gallery->title_ru) }}" required>
                                            @error('title_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                            <input type="text" name="slug_ru" id="slug_ru" class="form-control @error('slug_ru') is-invalid @enderror" value="{{ old('slug_ru', $gallery->slug_ru) }}">
                                            @error('slug_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Описание</label>
                                            <textarea name="description_ru" class="form-control @error('description_ru') is-invalid @enderror" rows="4" required>{{ old('description_ru', $gallery->description_ru) }}</textarea>
                                            @error('description_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- <div class="mb-3">
                                            <label class="form-label">ALT главного изображения</label>
                                            <input type="text" name="main_image_alt_ru" class="form-control @error('main_image_alt_ru') is-invalid @enderror" value="{{ old('main_image_alt_ru', $gallery->main_image_alt_ru) }}" required>
                                            @error('main_image_alt_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ALT нижнего изображения</label>
                                            <input type="text" name="bottom_image_alt_ru" class="form-control @error('bottom_image_alt_ru') is-invalid @enderror" value="{{ old('bottom_image_alt_ru', $gallery->bottom_image_alt_ru) }}" required>
                                            @error('bottom_image_alt_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Мета-заголовок</label>
                                            <input type="text" name="meta_title_ru" class="form-control" value="{{ old('meta_title_ru', $gallery->meta_title_ru) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Мета-описание</label>
                                            <textarea name="meta_description_ru" class="form-control" rows="3">{{ old('meta_description_ru', $gallery->meta_description_ru) }}</textarea>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary">Yadda saxla</button>
                                        <a href="{{ route('back.pages.galleries.index') }}" class="btn btn-secondary">Ləğv et</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
<script>
    function removeImage(button) {
        if (confirm('Bu şəkili silmək istədiyinizə əminsiniz?')) {
            const imageContainer = button.closest('.col-12');
            imageContainer.remove();
        }
    }

    function addImageInput() {
        const container = document.getElementById('additional-images-container');
        const wrapper = document.createElement('div');
        wrapper.className = 'mb-2 position-relative';
        
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'new_images[]';
        input.className = 'form-control';
        input.accept = 'image/*';
        
        const altContainer = document.createElement('div');
        altContainer.className = 'row mt-2';
        
        // Alt inputs for each language
        const languages = [
            // { code: 'az', placeholder: 'ALT mətni' },
            // { code: 'en', placeholder: 'ALT text' },
            // { code: 'ru', placeholder: 'ALT текст' }
        ];
        
        languages.forEach(lang => {
            const col = document.createElement('div');
            col.className = 'col-md-4';
            
            const altInput = document.createElement('input');
            altInput.type = 'text';
            altInput.name = `new_images_alt_${lang.code}[]`;
            altInput.className = 'form-control';
            altInput.placeholder = lang.placeholder;
            
            col.appendChild(altInput);
            altContainer.appendChild(col);
        });
        
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
        removeButton.innerHTML = '<i class="ri-delete-bin-line"></i>';
        removeButton.onclick = function() { this.closest('.mb-2').remove(); };
        
        wrapper.appendChild(input);
        wrapper.appendChild(altContainer);
        wrapper.appendChild(removeButton);
        container.appendChild(wrapper);
    }

    // Slug generation for each language
    document.addEventListener('DOMContentLoaded', function() {
        const slugify = (text) => {
            let trMap = {
                'çÇ':'c',
                'ğĞ':'g',
                'şŞ':'s',
                'üÜ':'u',
                'ıİ':'i',
                'öÖ':'o'
            };
            for(let key in trMap) {
                text = text.replace(new RegExp('['+key+']','g'), trMap[key]);
            }
            return text
                .toLowerCase()
                .replace(/[^-a-zA-Z0-9\s]+/ig, '') // Remove non-alphanumeric chars
                .replace(/\s/gi, "-") // Convert spaces to dashes
                .replace(/-+/g, "-") // Remove consecutive dashes
                .trim();
        };

        // For each language
        ['az', 'en', 'ru'].forEach(lang => {
            const titleInput = document.getElementById(`title_${lang}`);
            const slugInput = document.getElementById(`slug_${lang}`);
            
            titleInput.addEventListener('keyup', function() {
                if (!slugInput.value || slugInput.value === slugify(this.value)) {
                    slugInput.value = slugify(this.value);
                }
            });

            // Allow manual slug editing
            slugInput.addEventListener('keyup', function() {
                this.value = slugify(this.value);
            });
        });
    });
</script>
@endpush

@push('css')
<style>
    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        max-width: 100%;
        height: auto;
    }
    .position-relative {
        position: relative !important;
    }
    .position-absolute {
        position: absolute !important;
    }
    .top-0 {
        top: 0 !important;
    }
    .end-0 {
        right: 0 !important;
    }
</style>
@endpush 