@extends('back.layouts.master')

@section('title', 'Xidmətlər')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Xidmətlər</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item active">Xidmətlər</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Xidmətlər</h4>
                            <div class="mb-3">
                                <a href="{{ route('back.pages.services.create') }}" class="btn btn-primary">
                                    <i class="mdi mdi-plus me-1"></i> Yeni Xidmət
                                </a>
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
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Şəkil</th>
                                                    <!-- <th>Alt Şəkil</th> -->
                                                    <th>Başlıq</th>
                                                    <th>Mətn</th>
                                                    <th>Status</th>
                                                    <th>Əməliyyatlar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($services as $service)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if($service->image)
                                                            <img src="{{ asset($service->image) }}" alt="Service Image" 
                                                                 class="img-thumbnail" 
                                                                 style="width: 150px; height: 100px; object-fit: cover;">
                                                        @else
                                                            <span class="text-muted">Şəkil yoxdur</span>
                                                        @endif
                                                    </td>
                                                    <!-- <td>
                                                        @if($service->bottom_image)
                                                            <img src="{{ asset($service->bottom_image) }}" alt="Bottom Image" 
                                                                 class="img-thumbnail" 
                                                                 style="width: 150px; height: 100px; object-fit: cover;">
                                                        @else
                                                            <span class="text-muted">Şəkil yoxdur</span>
                                                        @endif
                                                    </td> -->
                                                    <td>{{ $service->title_az }}</td>
                                                    <td>
                                                        <div style="max-height: 100px; overflow: auto;">
                                                            {!! $service->description_az !!}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('back.pages.services.toggle-status', $service->id) }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-{{ $service->status ? 'success' : 'danger' }}">
                                                                {{ $service->status ? 'Aktiv' : 'Deaktiv' }}
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('back.pages.services.edit', $service->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('back.pages.services.destroy', $service->id) }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- EN Tab -->
                                <div class="tab-pane" id="en" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <!-- <th>Bottom Image</th> -->
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Operations</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($services as $service)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if($service->image)
                                                            <img src="{{ asset($service->image) }}" alt="Service Image" 
                                                                 class="img-thumbnail" 
                                                                 style="width: 150px; height: 100px; object-fit: cover;">
                                                        @else
                                                            <span class="text-muted">No image</span>
                                                        @endif
                                                    </td>
                                                    <!-- <td>
                                                        @if($service->bottom_image)
                                                            <img src="{{ asset($service->bottom_image) }}" alt="Bottom Image" 
                                                                 class="img-thumbnail" 
                                                                 style="width: 150px; height: 100px; object-fit: cover;">
                                                        @else
                                                            <span class="text-muted">No image</span>
                                                        @endif
                                                    </td> -->
                                                    <td>{{ $service->title_en }}</td>
                                                    <td>
                                                        <div style="max-height: 100px; overflow: auto;">
                                                            {!! $service->description_en !!}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('back.pages.services.toggle-status', $service->id) }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-{{ $service->status ? 'success' : 'danger' }}">
                                                                {{ $service->status ? 'Active' : 'Inactive' }}
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('back.pages.services.edit', $service->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('back.pages.services.destroy', $service->id) }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- RU Tab -->
                                <div class="tab-pane" id="ru" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Изображение</th>
                                                    <!-- <th>Нижнее Изображение</th> -->
                                                    <th>Заголовок</th>
                                                    <th>Описание</th>
                                                    <th>Статус</th>
                                                    <th>Операции</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($services as $service)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if($service->image)
                                                            <img src="{{ asset($service->image) }}" alt="Service Image" 
                                                                 class="img-thumbnail" 
                                                                 style="width: 150px; height: 100px; object-fit: cover;">
                                                        @else
                                                            <span class="text-muted">Нет изображения</span>
                                                        @endif
                                                    </td>
                                                    <!-- <td>
                                                        @if($service->bottom_image)
                                                            <img src="{{ asset($service->bottom_image) }}" alt="Bottom Image" 
                                                                 class="img-thumbnail" 
                                                                 style="width: 150px; height: 100px; object-fit: cover;">
                                                        @else
                                                            <span class="text-muted">Нет изображения</span>
                                                        @endif
                                                    </td> -->
                                                    <td>{{ $service->title_ru }}</td>
                                                    <td>
                                                        <div style="max-height: 100px; overflow: auto;">
                                                            {!! $service->description_ru !!}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('back.pages.services.toggle-status', $service->id) }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-{{ $service->status ? 'success' : 'danger' }}">
                                                                {{ $service->status ? 'Активный' : 'Неактивный' }}
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('back.pages.services.edit', $service->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('back.pages.services.destroy', $service->id) }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{ $services->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection