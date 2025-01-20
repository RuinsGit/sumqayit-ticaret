@extends('back.layouts.master')

@section('title', 'Qalereya')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Qalereya</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item active">Qalereya</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">Qalereya Siyahısı</h5>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('back.pages.galleries.create') }}" class="btn btn-primary">
                                        <i class="ri-add-line align-bottom me-1"></i> Yeni Qalereya
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-nowrap align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 50px;">#</th>
                                            <th scope="col" class="text-center" style="width: 150px;">Əsas Şəkil</th>
                                            <th scope="col">Başlıq</th>
                                            <th scope="col" class="text-center" style="width: 150px;">Alt Şəkil</th>
                                            <th scope="col" class="text-center" style="width: 150px;">Əlavə Şəkillər</th>
                                            <th scope="col" class="text-center" style="width: 120px;">Əməliyyatlar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($galleries as $gallery)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    <img src="{{ asset('storage/' . $gallery->main_image) }}" 
                                                         alt="{{ $gallery->main_image_alt_az }}"
                                                         class="img-thumbnail"
                                                         style="max-height: 80px;">
                                                </td>
                                                <td>
                                                    <h5 class="mb-1">{{ $gallery->title_az }}</h5>
                                                    <p class="text-muted mb-0">{{ Str::limit($gallery->description_az, 100) }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <img src="{{ asset('storage/' . $gallery->bottom_image) }}" 
                                                         alt="{{ $gallery->bottom_image_alt_az }}"
                                                         class="img-thumbnail"
                                                         style="max-height: 80px;">
                                                </td>
                                                <td class="text-center">
                                                    @if($gallery->multiple_images)
                                                        <div class="avatar-group">
                                                            @foreach(array_slice($gallery->multiple_images, 0, 3) as $image)
                                                                <img src="{{ asset('storage/' . $image['image']) }}" 
                                                                     alt="{{ $image['alt_az'] }}"
                                                                     class="img-thumbnail"
                                                                     style="max-height: 50px; margin-right: 5px;">
                                                            @endforeach
                                                            @if(count($gallery->multiple_images) > 3)
                                                                <span class="badge bg-light text-dark">+{{ count($gallery->multiple_images) - 3 }}</span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="badge bg-light text-dark">Şəkil yoxdur</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('back.pages.galleries.edit', $gallery->id) }}" 
                                                           class="btn btn-warning btn-sm" 
                                                           title="Redaktə et">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                        <form action="{{ route('back.pages.galleries.destroy', $gallery->id) }}" 
                                                              method="POST"
                                                              onsubmit="return confirm('Silmək istədiyinizə əminsiniz?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Sil">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Heç bir məlumat tapılmadı</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .table img {
        object-fit: cover;
        border-radius: 4px;
    }
    .avatar-group {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush 