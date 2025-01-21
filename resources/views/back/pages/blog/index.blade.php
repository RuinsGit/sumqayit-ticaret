@extends('back.layouts.master')

@section('title', 'Bloqlar')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Bloqlar</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item active">Bloqlar</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('back.pages.blog.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Yeni Bloq
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Şəkil</th>
                                            <th>Başlıq (AZ)</th>
                                            <th>Başlıq (EN)</th>
                                            <th>Başlıq (RU)</th>
                                            <th>Alt Şəkillər</th>
                                            <th class="text-center" style="width: 150px;">Əməliyyatlar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($blogs as $blog)
                                            <tr>
                                                <td>{{ $blog->id }}</td>
                                                <td>
                                                    <img src="{{ asset($blog->main_image) }}" alt="" style="width: 100px; height: auto;">
                                                </td>
                                                <td>{{ $blog->title_az }}</td>
                                                <td>{{ $blog->title_en }}</td>
                                                <td>{{ $blog->title_ru }}</td>
                                                <td>
                                                    @if($blog->bottom_images)
                                                        <span class="badge bg-info">{{ count(json_decode($blog->bottom_images)) }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">0</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('back.pages.blog.edit', $blog->id) }}" 
                                                        class="btn btn-warning btn-sm" title="Düzəliş et">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="deleteData('{{ route('back.pages.blog.destroy', $blog->id) }}')"
                                                            title="Sil">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Heç bir məlumat tapılmadı.</td>
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

    <!-- Delete Form -->
    <form id="delete-form" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    @push('js')
    <script>
        function deleteData(url) {
            if (confirm('Silmək istədiyinizə əminsiniz?')) {
                var form = document.getElementById('delete-form');
                form.setAttribute('action', url);
                form.submit();
            }
        }
    </script>
    @endpush
@endsection
