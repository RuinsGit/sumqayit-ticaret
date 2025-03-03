@extends('back.layouts.master')

@section('title', 'Yeni Bloq')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Yeni Bloq</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('back.pages.blog.index') }}">Bloqlar</a></li>
                                <li class="breadcrumb-item active">Yeni</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('back.pages.blog.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Şəkil Yükləmə Bölməsi -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Əsas Şəkil (1440x500)</label>
                                            <input type="file" name="main_image" class="form-control @error('main_image') is-invalid @enderror" required>
                                            @error('main_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Alt Şəkillər (847x380)</label>
                                            <div id="bottom-images-container">
                                                <div class="input-group mb-2">
                                                    <input type="file" name="bottom_images[]" class="form-control">
                                                    <button type="button" class="btn btn-danger" onclick="removeBottomImage(this)">Sil</button>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-warning" onclick="addBottomImage()">Yeni Şəkil Əlavə Et</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#az" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Azərbaycan</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#en" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">İngilis</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#ru" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">Rus</span>
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content p-3">
                                    <!-- Azərbaycan dili -->
                                    <div class="tab-pane active" id="az" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Başlıq</label>
                                            <input type="text" name="title_az" id="title_az" class="form-control @error('title_az') is-invalid @enderror" required>
                                            @error('title_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                            <input type="text" name="slug_az" id="slug_az" class="form-control @error('slug_az') is-invalid @enderror">
                                            @error('slug_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
<!-- 
                                        <div class="mb-3">
                                            <label class="form-label">Əsas Şəkil ALT</label>
                                            <input type="text" name="main_image_alt_az" class="form-control @error('main_image_alt_az') is-invalid @enderror" required>
                                            @error('main_image_alt_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Alt Şəkillər ALT</label>
                                            <div id="bottom-images-alt-container-az">
                                                <input type="text" name="bottom_images_alt_az[]" class="form-control mb-2" placeholder="ALT mətni">
                                            </div>
                                            <button type="button" class="btn btn-warning mt-2" onclick="addBottomImageAlt('az')">Yeni ALT Mətn Əlavə Et</button>
                                        </div> -->

                                        <div class="mb-3">
                                            <label class="form-label">Mətn</label>
                                            <textarea name="text_az" class="form-control @error('text_az') is-invalid @enderror" rows="5" required></textarea>
                                            @error('text_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Məzmun 1</label>
                                            <textarea name="description_1_az" class="form-control summernote"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Məzmun 2</label>
                                            <textarea name="description_2_az" class="form-control summernote"></textarea>
                                        </div>

                                        <!-- <div class="mb-3">
                                            <label class="form-label">Meta Başlıq</label>
                                            <input type="text" name="meta_title_az" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Meta Məzmun</label>
                                            <textarea name="meta_description_az" class="form-control" rows="3"></textarea>
                                        </div> -->
                                    </div>

                                    <!-- İngilis dili -->
                                    <div class="tab-pane" id="en" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="title_en" id="title_en" class="form-control @error('title_en') is-invalid @enderror" required>
                                            @error('title_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                            <input type="text" name="slug_en" id="slug_en" class="form-control @error('slug_en') is-invalid @enderror">
                                            @error('slug_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
<!-- 
                                        <div class="mb-3">
                                            <label class="form-label">Main Image ALT</label>
                                            <input type="text" name="main_image_alt_en" class="form-control @error('main_image_alt_en') is-invalid @enderror" required>
                                            @error('main_image_alt_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Bottom Images ALT</label>
                                            <div id="bottom-images-alt-container-en">
                                                <input type="text" name="bottom_images_alt_en[]" class="form-control mb-2" placeholder="ALT text">
                                            </div>
                                            <button type="button" class="btn btn-warning mt-2" onclick="addBottomImageAlt('en')">Add New ALT Text</button>
                                        </div> -->

                                        <div class="mb-3">
                                            <label class="form-label">Text</label>
                                            <textarea name="text_en" class="form-control @error('text_en') is-invalid @enderror" rows="5" required></textarea>
                                            @error('text_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Description 1</label>
                                            <textarea name="description_1_en" class="form-control summernote"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Description 2</label>
                                            <textarea name="description_2_en" class="form-control summernote"></textarea>
                                        </div>

                                        <!-- <div class="mb-3">
                                            <label class="form-label">Meta Title</label>
                                            <input type="text" name="meta_title_en" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Meta Description</label>
                                            <textarea name="meta_description_en" class="form-control" rows="3"></textarea>
                                        </div> -->
                                    </div>

                                    <!-- Rus dili -->
                                    <div class="tab-pane" id="ru" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Заголовок</label>
                                            <input type="text" name="title_ru" id="title_ru" class="form-control @error('title_ru') is-invalid @enderror" required>
                                            @error('title_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                            <input type="text" name="slug_ru" id="slug_ru" class="form-control @error('slug_ru') is-invalid @enderror">
                                            @error('slug_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- <div class="mb-3">
                                            <label class="form-label">ALT главного изображения</label>
                                            <input type="text" name="main_image_alt_ru" class="form-control @error('main_image_alt_ru') is-invalid @enderror" required>
                                            @error('main_image_alt_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">ALT нижних изображений</label>
                                            <div id="bottom-images-alt-container-ru">
                                                <input type="text" name="bottom_images_alt_ru[]" class="form-control mb-2" placeholder="ALT текст">
                                            </div>
                                            <button type="button" class="btn btn-warning mt-2" onclick="addBottomImageAlt('ru')">Добавить новый ALT текст</button>
                                        </div> -->

                                        <div class="mb-3">
                                            <label class="form-label">Текст</label>
                                            <textarea name="text_ru" class="form-control @error('text_ru') is-invalid @enderror" rows="5" required></textarea>
                                            @error('text_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Описание 1</label>
                                            <textarea name="description_1_ru" class="form-control summernote"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Описание 2</label>
                                            <textarea name="description_2_ru" class="form-control summernote"></textarea>
                                        </div>

                                        <!-- <div class="mb-3">
                                            <label class="form-label">Мета-заголовок</label>
                                            <input type="text" name="meta_title_ru" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Мета-описание</label>
                                            <textarea name="meta_description_ru" class="form-control" rows="3"></textarea>
                                        </div> -->
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Yadda saxla</button>
                                        <a href="{{ route('back.pages.blog.index') }}" class="btn btn-secondary">Ləğv et</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    @endpush

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function addBottomImage() {
            const container = document.getElementById('bottom-images-container');
            const wrapper = document.createElement('div');
            wrapper.className = 'input-group mb-2';
            
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'bottom_images[]';
            input.className = 'form-control';
            
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-danger';
            button.onclick = function() { removeBottomImage(this); };
            button.textContent = 'Sil';
            
            wrapper.appendChild(input);
            wrapper.appendChild(button);
            container.appendChild(wrapper);
        }

        function removeBottomImage(button) {
            const wrapper = button.closest('.input-group');
            if (wrapper) {
                wrapper.remove();
            }
        }

        function addBottomImageAlt(lang) {
            const container = document.getElementById(`bottom-images-alt-container-${lang}`);
            const input = document.createElement('input');
            input.type = 'text';
            input.name = `bottom_images_alt_${lang}[]`;
            input.className = 'form-control mb-2';
            input.placeholder = lang === 'ru' ? 'ALT текст' : (lang === 'en' ? 'ALT text' : 'ALT mətni');
            container.appendChild(input);
        }

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

            // Sweet Alert for form submission
            $('form').on('submit', function(e) {
                e.preventDefault();
                let form = this;
                
                Swal.fire({
                    title: 'Əminsiniz?',
                    text: 'Bu məlumatları yadda saxlamaq istədiyinizə əminsiniz?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Bəli',
                    cancelButtonText: 'Xeyr'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Slug generation for each language
        document.addEventListener('DOMContentLoaded', function() {
            const slugify = (text) => {
                let trMap = {
                    'çÇ':'c',
                    'ğĞ':'g',
                    'şŞ':'s',
                    'üÜ':'u',
                    'ıİ':'i',
                    'öÖ':'o',
                    'əƏ':'e'
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
@endsection
