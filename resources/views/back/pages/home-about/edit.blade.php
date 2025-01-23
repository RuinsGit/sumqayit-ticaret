@extends('back.layouts.master')

@section('title', 'Home About Dəyişdir')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Home About Dəyişdir</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('back.pages.home-about.index') }}">Home About</a></li>
                            <li class="breadcrumb-item active">Dəyişdir</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('back.pages.home-about.update', $homeAbout->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Image Upload Section -->
                            <div class="mb-4">
                                <label class="form-label">Şəkillər</label>
                                <div id="images-container">
                                    @if($homeAbout->images)
                                        @foreach(json_decode($homeAbout->images) as $key => $image)
                                            <div class="mb-4">
                                                <div class="input-group mb-2">
                                                    <img src="{{ asset($image) }}" alt="Current Image" width="50" class="me-2">
                                                    <input type="file" name="images[]" class="form-control">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger" onclick="removeImage(this)">Sil</button>
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <label class="form-label">Alt Text (AZ)</label>
                                                    <input type="text" name="images_alt_az[]" class="form-control" 
                                                        value="{{ $homeAbout->images_alt_az ? json_decode($homeAbout->images_alt_az)[$key] ?? '' : '' }}">
                                                    
                                                    <label class="form-label mt-2">Alt Text (EN)</label>
                                                    <input type="text" name="images_alt_en[]" class="form-control"
                                                        value="{{ $homeAbout->images_alt_en ? json_decode($homeAbout->images_alt_en)[$key] ?? '' : '' }}">
                                                    
                                                    <label class="form-label mt-2">Alt Text (RU)</label>
                                                    <input type="text" name="images_alt_ru[]" class="form-control"
                                                        value="{{ $homeAbout->images_alt_ru ? json_decode($homeAbout->images_alt_ru)[$key] ?? '' : '' }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="mb-4">
                                            <div class="input-group mb-2">
                                                <input type="file" name="images[]" class="form-control">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger" onclick="removeImage(this)">Sil</button>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <label class="form-label">Alt Text (AZ)</label>
                                                <input type="text" name="images_alt_az[]" class="form-control">
                                                <label class="form-label mt-2">Alt Text (EN)</label>
                                                <input type="text" name="images_alt_en[]" class="form-control">
                                                <label class="form-label mt-2">Alt Text (RU)</label>
                                                <input type="text" name="images_alt_ru[]" class="form-control">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-warning mt-2" onclick="addImage()">Yeni Şəkil Əlavə Et</button>
                            </div>

                            <!-- Description Section -->
                            <div class="mb-4">
                                <label class="form-label">Açıqlama (AZ)</label>
                                <textarea name="description_az" class="form-control" rows="3">{{ $homeAbout->description_az }}</textarea>
                                <label class="form-label mt-2">Açıqlama (EN)</label>
                                <textarea name="description_en" class="form-control" rows="3">{{ $homeAbout->description_en }}</textarea>
                                <label class="form-label mt-2">Açıqlama (RU)</label>
                                <textarea name="description_ru" class="form-control" rows="3">{{ $homeAbout->description_ru }}</textarea>
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
                                        <input type="text" name="title1_az" class="form-control" value="{{ $homeAbout->title1_az }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Başlıq 2</label>
                                        <input type="text" name="title2_az" class="form-control" value="{{ $homeAbout->title2_az }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Xüsusi Başlıq 1</label>
                                        <input type="text" name="special_title1_az" class="form-control" value="{{ $homeAbout->special_title1_az }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Xüsusi Başlıq 2</label>
                                        <input type="text" name="special_title2_az" class="form-control" value="{{ $homeAbout->special_title2_az }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Xüsusi Başlıq 3</label>
                                        <input type="text" name="special_title3_az" class="form-control" value="{{ $homeAbout->special_title3_az }}">
                                    </div>
                                </div>

                                <!-- EN Tab -->
                                <div class="tab-pane" id="en" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label">Title 1</label>
                                        <input type="text" name="title1_en" class="form-control" value="{{ $homeAbout->title1_en }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Title 2</label>
                                        <input type="text" name="title2_en" class="form-control" value="{{ $homeAbout->title2_en }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Special Title 1</label>
                                        <input type="text" name="special_title1_en" class="form-control" value="{{ $homeAbout->special_title1_en }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Special Title 2</label>
                                        <input type="text" name="special_title2_en" class="form-control" value="{{ $homeAbout->special_title2_en }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Special Title 3</label>
                                        <input type="text" name="special_title3_en" class="form-control" value="{{ $homeAbout->special_title3_en }}">
                                    </div>
                                </div>

                                <!-- RU Tab -->
                                <div class="tab-pane" id="ru" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label">Заголовок 1</label>
                                        <input type="text" name="title1_ru" class="form-control" value="{{ $homeAbout->title1_ru }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Заголовок 2</label>
                                        <input type="text" name="title2_ru" class="form-control" value="{{ $homeAbout->title2_ru }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Специальный Заголовок 1</label>
                                        <input type="text" name="special_title1_ru" class="form-control" value="{{ $homeAbout->special_title1_ru }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Специальный Заголовок 2</label>
                                        <input type="text" name="special_title2_ru" class="form-control" value="{{ $homeAbout->special_title2_ru }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Специальный Заголовок 3</label>
                                        <input type="text" name="special_title3_ru" class="form-control" value="{{ $homeAbout->special_title3_ru }}">
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
        wrapper.className = 'mb-4';

        // Image input
        const imageGroup = document.createElement('div');
        imageGroup.className = 'input-group mb-2';
        
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'images[]';
        input.className = 'form-control';

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

        // EN
        const labelEn = document.createElement('label');
        labelEn.className = 'form-label mt-2';
        labelEn.textContent = 'Alt Text (EN)';
        const inputEn = document.createElement('input');
        inputEn.type = 'text';
        inputEn.name = 'images_alt_en[]';
        inputEn.className = 'form-control';

        // RU
        const labelRu = document.createElement('label');
        labelRu.className = 'form-label mt-2';
        labelRu.textContent = 'Alt Text (RU)';
        const inputRu = document.createElement('input');
        inputRu.type = 'text';
        inputRu.name = 'images_alt_ru[]';
        inputRu.className = 'form-control';

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
        const wrapper = button.closest('.mb-4');
        if (wrapper) {
            wrapper.remove();
        }
    }
</script>
@endsection
