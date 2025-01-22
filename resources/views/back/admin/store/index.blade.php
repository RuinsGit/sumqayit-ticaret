@extends('back.layouts.master')

@section('title', 'Mağazalar')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Mağazalar</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item active">Mağazalar</li>
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
                                <a href="{{ route('back.pages.store.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Yeni Mağaza
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Növ</th>
                                            <th>Şəkil</th>
                                            <th>İkonlar</th>
                                            <th>Email</th>
                                            <th>Nömrə</th>
                                            <th>Status</th>
                                            <th class="text-center" style="width: 150px;">Əməliyyatlar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($stores as $store)
                                            <tr>
                                                <td>{{ $store->id }}</td>
                                                <td>{{ $store->storeType->name_az }}</td>
                                                <td>
                                                    @if($store->image)
                                                        <img src="{{ asset($store->image) }}" alt="" style="height: 50px;">
                                                    @else
                                                        <span class="badge bg-secondary">Şəkil yoxdur</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        @if($store->working_hours_image)
                                                            <img src="{{ asset($store->working_hours_image) }}" alt="İş saatları" title="İş saatları" style="height: 30px;">
                                                        @endif
                                                        @if($store->number_image)
                                                            <img src="{{ asset($store->number_image) }}" alt="Nömrə" title="Nömrə" style="height: 30px;">
                                                        @endif
                                                        @if($store->email_image)
                                                            <img src="{{ asset($store->email_image) }}" alt="Email" title="Email" style="height: 30px;">
                                                        @endif
                                                        @if($store->link_image)
                                                            <img src="{{ asset($store->link_image) }}" alt="Link" title="Link" style="height: 30px;">
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $store->email }}</td>
                                                <td>{{ $store->number }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $store->status ? 'success' : 'danger' }}">
                                                        {{ $store->status ? 'Aktiv' : 'Deaktiv' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('back.pages.store.edit', $store->id) }}" 
                                                        class="btn btn-warning btn-sm" title="Düzəliş et">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="deleteData('{{ route('back.pages.store.destroy', $store->id) }}')"
                                                            title="Sil">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Heç bir məlumat tapılmadı.</td>
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