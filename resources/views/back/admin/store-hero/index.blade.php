@extends('back.layouts.master')

@section('title', 'Hero Siyahısı')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Hero Siyahısı</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                            <li class="breadcrumb-item active">Hero</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-4">
                            <a href="{{ route('back.pages.store-hero.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Yeni Hero Əlavə Et
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Şəkil</th>
                                        <th>Başlıq (AZ)</th>
                                        <th>Təsvir (AZ)</th>
                                        <th>Əməliyyatlar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($storeHero as $hero)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($hero->image) }}" 
                                                     alt="{{ $hero->image_alt_az }}" 
                                                     class="img-thumbnail" 
                                                     style="max-width: 100px;">
                                            </td>
                                            <td>{{ $hero->title_az }}</td>
                                            <td>{{ Str::limit($hero->description_az, 100) }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('back.pages.store-hero.edit', $hero->id) }}" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('back.pages.store-hero.destroy', $hero->id) }}" 
                                                          method="POST" 
                                                          class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Bu Hero-nu silmək istədiyinizə əminsiniz?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Heç bir Hero tapılmadı</td>
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

<style>
.table {
    vertical-align: middle;
}

.table img {
    transition: transform 0.2s ease;
}

.table img:hover {
    transform: scale(1.1);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.alert {
    margin-bottom: 1rem;
    padding: 1rem;
    border-radius: 0.5rem;
}

.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
    border-radius: 12px;
}
</style>
@endsection 