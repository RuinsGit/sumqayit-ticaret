@extends('back.layouts.master')

@section('title', 'Mağaza Növləri')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Mağaza Növləri</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item active">Mağaza Növləri</li>
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
                                <a href="{{ route('back.pages.store-type.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Yeni Mağaza Növü
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Ad (AZ)</th>
                                            <th>Ad (EN)</th>
                                            <th>Ad (RU)</th>
                                            <th>Status</th>
                                            <th class="text-center" style="width: 150px;">Əməliyyatlar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($storeTypes as $storeType)
                                            <tr>
                                                <td>{{ $storeType->id }}</td>
                                                <td>{{ $storeType->name_az }}</td>
                                                <td>{{ $storeType->name_en }}</td>
                                                <td>{{ $storeType->name_ru }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $storeType->status ? 'success' : 'danger' }}">
                                                        {{ $storeType->status ? 'Aktiv' : 'Deaktiv' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('back.pages.store-type.edit', $storeType->id) }}" 
                                                        class="btn btn-warning btn-sm" title="Düzəliş et">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="deleteData('{{ route('back.pages.store-type.destroy', $storeType->id) }}')"
                                                            title="Sil">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Heç bir məlumat tapılmadı.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteData(url) {
            Swal.fire({
                title: 'Əminsiniz?',
                text: "Bu məlumatı silmək istədiyinizə əminsiniz?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bəli, sil!',
                cancelButtonText: 'Ləğv et'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.getElementById('delete-form');
                    form.setAttribute('action', url);
                    form.submit();
                }
            });
        }

        // Display success message if exists
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Uğurlu!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>
    @endpush
@endsection 