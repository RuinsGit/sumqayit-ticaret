@extends('back.layouts.master')

@section('title', 'Video Qalereya')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Video Qalereya</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item active">Video Qalereya</li>
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
                                <h5 class="card-title mb-0 flex-grow-1">Video Qalereya Siyahısı</h5>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('back.pages.gallery-videos.create') }}" class="btn btn-primary">
                                        <i class="ri-add-line align-bottom me-1"></i> Yeni Video
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
                                            <th scope="col" class="text-center" style="width: 150px;">Əsas Video</th>
                                            <th scope="col">Başlıq</th>
                                            <th scope="col" class="text-center" style="width: 150px;">Alt Video</th>
                                            <th scope="col" class="text-center" style="width: 150px;">Əlavə Videolar</th>
                                            <th scope="col" class="text-center" style="width: 120px;">Əməliyyatlar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($galleryVideos as $galleryVideo)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    @if($galleryVideo->main_video_thumbnail)
                                                        <img src="{{ asset($galleryVideo->main_video_thumbnail) }}" 
                                                             alt="{{ $galleryVideo->main_video_alt_az }}"
                                                             class="img-thumbnail"
                                                             style="max-height: 80px;">
                                                    @else
                                                        <span class="badge bg-light text-dark">Şəkil yoxdur</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <h5 class="mb-1">{{ $galleryVideo->title_az }}</h5>
                                                </td>
                                                <td class="text-center">
                                                    @if($galleryVideo->bottom_video_thumbnail)
                                                        <img src="{{ asset($galleryVideo->bottom_video_thumbnail) }}" 
                                                             alt="{{ $galleryVideo->bottom_video_alt_az }}"
                                                             class="img-thumbnail"
                                                             style="max-height: 80px;">
                                                    @else
                                                        <span class="badge bg-light text-dark">Şəkil yoxdur</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($galleryVideo->multiple_videos)
                                                        <div class="avatar-group">
                                                            @foreach(array_slice(is_string($galleryVideo->multiple_videos) ? json_decode($galleryVideo->multiple_videos, true) : $galleryVideo->multiple_videos, 0, 3) as $video)
                                                                <img src="{{ asset($video['thumbnail']) }}" 
                                                                     alt="{{ $video['alt_az'] }}"
                                                                     class="img-thumbnail"
                                                                     style="max-height: 50px; margin-right: 5px;">
                                                            @endforeach
                                                            @if(count(is_string($galleryVideo->multiple_videos) ? json_decode($galleryVideo->multiple_videos, true) : $galleryVideo->multiple_videos) > 3)
                                                                <span class="badge bg-light text-dark">+{{ count(is_string($galleryVideo->multiple_videos) ? json_decode($galleryVideo->multiple_videos, true) : $galleryVideo->multiple_videos) - 3 }}</span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="badge bg-light text-dark">Video yoxdur</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('back.pages.gallery-videos.edit', $galleryVideo->id) }}" 
                                                           class="btn btn-warning btn-sm" 
                                                           title="Redaktə et">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                        <form action="{{ route('back.pages.gallery-videos.destroy', $galleryVideo->id) }}" 
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