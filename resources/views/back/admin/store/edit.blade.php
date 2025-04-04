@extends('back.layouts.master')

@section('title', 'Mağazanı Redaktə Et')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Mağazanı Redaktə Et</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('back.pages.store.index') }}">Mağazalar</a></li>
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
                            <form action="{{ route('back.pages.store.update', $store->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Store Type Selection -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Kateqoriya</label>
                                        <select name="store_type_id" id="store_type_id" class="form-select @error('store_type_id') is-invalid @enderror">
                                            <option value="">Seçin</option>
                                            @foreach($storeTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('store_type_id', $store->store_type_id) == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name_az }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('store_type_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Brend</label>
                                        <select name="market_id" id="market_id" class="form-select @error('market_id') is-invalid @enderror">
                                            <option value="">Seçin</option>
                                            @foreach($markets as $market)
                                                <option value="{{ $market->id }}" {{ old('market_id', $store->market_id) == $market->id ? 'selected' : '' }}>
                                                    {{ $market->name_az }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('market_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @error('selection_error')
                                        <div class="col-md-8 mt-2">
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Image Upload Section -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Əsas Şəkil</label>
                                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                            @if($store->image)
                                                <div class="mt-2">
                                                    <img src="{{ asset($store->image) }}" alt="" class="img-fluid" style="max-height: 100px;">
                                                </div>
                                            @endif
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Alt Şəkil</label>
                                            <input type="file" name="bottom_image" class="form-control @error('bottom_image') is-invalid @enderror">
                                            @if($store->bottom_image)
                                                <div class="mt-2">
                                                    <img src="{{ asset($store->bottom_image) }}" alt="" class="img-fluid" style="max-height: 100px;">
                                                </div>
                                            @endif
                                            @error('bottom_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">İş Saatları Şəkli</label>
                                            <input type="file" name="working_hours_image" class="form-control @error('working_hours_image') is-invalid @enderror">
                                            @if($store->working_hours_image)
                                                <div class="mt-2">
                                                    <img src="{{ asset($store->working_hours_image) }}" alt="" class="img-fluid" style="max-height: 50px;">
                                                </div>
                                            @endif
                                            @error('working_hours_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Images -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Nömrə Şəkli</label>
                                            <input type="file" name="number_image" class="form-control @error('number_image') is-invalid @enderror">
                                            @if($store->number_image)
                                                <div class="mt-2">
                                                    <img src="{{ asset($store->number_image) }}" alt="" class="img-fluid" style="max-height: 50px;">
                                                </div>
                                            @endif
                                            @error('number_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Email Şəkli</label>
                                            <input type="file" name="email_image" class="form-control @error('email_image') is-invalid @enderror">
                                            @if($store->email_image)
                                                <div class="mt-2">
                                                    <img src="{{ asset($store->email_image) }}" alt="" class="img-fluid" style="max-height: 50px;">
                                                </div>
                                            @endif
                                            @error('email_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Link Şəkli</label>
                                            <input type="file" name="link_image" class="form-control @error('link_image') is-invalid @enderror">
                                            @if($store->link_image)
                                                <div class="mt-2">
                                                    <img src="{{ asset($store->link_image) }}" alt="" class="img-fluid" style="max-height: 50px;">
                                                </div>
                                            @endif
                                            @error('link_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
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
                                <div class="tab-content p-3">
                                    <!-- AZ Tab -->
                                    <div class="tab-pane active" id="az" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Təsvir</label>
                                            <textarea name="description_az" class="form-control summernote @error('description_az') is-invalid @enderror" rows="4" required>{{ old('description_az', $store->description_az) }}</textarea>
                                            @error('description_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">İş Saatları</label>
                                            <input type="text" name="working_hours_az" class="form-control @error('working_hours_az') is-invalid @enderror" value="{{ old('working_hours_az', $store->working_hours_az) }}" required>
                                            @error('working_hours_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Əsas Şəkil ALT</label>
                                            <input type="text" name="image_alt_az" class="form-control @error('image_alt_az') is-invalid @enderror" value="{{ old('image_alt_az', $store->image_alt_az) }}">
                                            @error('image_alt_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Alt Şəkil ALT</label>
                                            <input type="text" name="bottom_image_alt_az" class="form-control @error('bottom_image_alt_az') is-invalid @enderror" value="{{ old('bottom_image_alt_az', $store->bottom_image_alt_az) }}">
                                            @error('bottom_image_alt_az')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- EN Tab -->
                                    <div class="tab-pane" id="en" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description_en" class="form-control summernote @error('description_en') is-invalid @enderror" rows="4">{{ old('description_en', $store->description_en) }}</textarea>
                                            @error('description_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Working Hours</label>
                                            <input type="text" name="working_hours_en" class="form-control @error('working_hours_en') is-invalid @enderror" value="{{ old('working_hours_en', $store->working_hours_en) }}">
                                            @error('working_hours_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Main Image ALT</label>
                                            <input type="text" name="image_alt_en" class="form-control @error('image_alt_en') is-invalid @enderror" value="{{ old('image_alt_en', $store->image_alt_en) }}">
                                            @error('image_alt_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Bottom Image ALT</label>
                                            <input type="text" name="bottom_image_alt_en" class="form-control @error('bottom_image_alt_en') is-invalid @enderror" value="{{ old('bottom_image_alt_en', $store->bottom_image_alt_en) }}">
                                            @error('bottom_image_alt_en')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- RU Tab -->
                                    <div class="tab-pane" id="ru" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Описание</label>
                                            <textarea name="description_ru" class="form-control summernote @error('description_ru') is-invalid @enderror" rows="4">{{ old('description_ru', $store->description_ru) }}</textarea>
                                            @error('description_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Рабочие часы</label>
                                            <input type="text" name="working_hours_ru" class="form-control @error('working_hours_ru') is-invalid @enderror" value="{{ old('working_hours_ru', $store->working_hours_ru) }}">
                                            @error('working_hours_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ALT главного изображения</label>
                                            <input type="text" name="image_alt_ru" class="form-control @error('image_alt_ru') is-invalid @enderror" value="{{ old('image_alt_ru', $store->image_alt_ru) }}">
                                            @error('image_alt_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ALT нижнего изображения</label>
                                            <input type="text" name="bottom_image_alt_ru" class="form-control @error('bottom_image_alt_ru') is-invalid @enderror" value="{{ old('bottom_image_alt_ru', $store->bottom_image_alt_ru) }}">
                                            @error('bottom_image_alt_ru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Nömrə</label>
                                        <input type="text" name="number" class="form-control @error('number') is-invalid @enderror" value="{{ old('number', $store->number) }}" required>
                                        @error('number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $store->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Link</label>
                                        <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $store->link) }}">
                                        @error('link')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="1" {{ old('status', $store->status) == 1 ? 'selected' : '' }}>Aktiv</option>
                                            <option value="0" {{ old('status', $store->status) == 0 ? 'selected' : '' }}>Deaktiv</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Yadda saxla</button>
                                        <a href="{{ route('back.pages.store.index') }}" class="btn btn-secondary">Ləğv et</a>
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

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Xəta!',
            html: '@foreach($errors->all() as $error){{ $error }}<br>@endforeach',
            confirmButtonText: 'Tamam'
        });
    @endif
</script>
@endsection

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

        // Form gönderilmeden önce disable edilmiş alanları temizle
        $('form').on('submit', function() {
            if ($('#store_type_id').val() !== '') {
                $('#market_id').val('');
            }
            
            if ($('#market_id').val() !== '') {
                $('#store_type_id').val('');
            }
            
            // Disable olan elementlerin değerlerini temizle
            $('#store_type_id, #market_id').prop('disabled', false);
            return true;
        });

        // Kategori-Marka seçim kontrolü
        $('#store_type_id').on('change', function() {
            if($(this).val() !== '') {
                $('#market_id').prop('disabled', true).val('');
            } else {
                $('#market_id').prop('disabled', false);
            }
        });

        $('#market_id').on('change', function() {
            if($(this).val() !== '') {
                $('#store_type_id').prop('disabled', true).val('');
            } else {
                $('#store_type_id').prop('disabled', false);
            }
        });

        // Sayfa yüklendiğinde mevcut değerlere göre durumu ayarla
        if($('#store_type_id').val() !== '') {
            $('#market_id').prop('disabled', true).val('');
        }
        
        if($('#market_id').val() !== '') {
            $('#store_type_id').prop('disabled', true).val('');
        }
    });
</script>
@endpush 