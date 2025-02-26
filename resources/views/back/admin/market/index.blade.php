@extends('back.layouts.master')

@section('title', 'Brendlər')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Brendlər</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                            <li class="breadcrumb-item active">Brendlər</li>
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
                            <a href="{{ route('back.pages.market.create') }}" class="btn btn-primary">
                                <i class="ri-add-line"></i> Yeni Brend Əlavə Et
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table id="data-table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Şəkil</th>
                                        <th>Ad</th>
                                        <th>Status</th>
                                        <th>Əməliyyatlar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($markets as $market)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($market->image)
                                                    <img src="{{ asset($market->image) }}" alt="{{ $market->image_alt_az }}" width="100">
                                                @else
                                                    <span class="badge badge-soft-danger">Yox</span>
                                                @endif
                                            </td>
                                            <td>{{ $market->name_az }}</td>
                                            <td>
                                                @if($market->status)
                                                    <span class="badge badge-soft-success">Aktiv</span>
                                                @else
                                                    <span class="badge badge-soft-danger">Deaktiv</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('back.pages.market.edit', $market->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                                <form action="{{ route('back.pages.market.destroy', $market->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Silmək istədiyinizə əminsiniz?')">
                                                        <i class="ri-delete-bin-line"></i>
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Uğurlu!',
            text: '{{ session("success") }}',
            confirmButtonText: 'Tamam'
        });
    @endif
</script>
@endsection 