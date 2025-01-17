@extends('back.layouts.master')

@section('title', 'Tərcümələr')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title">Translation</h4>
                            <a href="{{ route('back.pages.translation-manage.create') }}" class="btn btn-primary waves-effect waves-light">
                                <i class="ri-add-line align-middle me-1"></i> Add New Translation
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Key</th>
                                        <th>Value (AZ)</th>
                                        <th>Value (EN)</th>
                                        <th>Value (RU)</th>
                                        <th>Status</th>
                                        <th>Əməliyyatlar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($translationManages as $translation)
                                    <tr>
                                        <td>{{ $translation->key }}</td>
                                        <td>{{ $translation->value_az }}</td>
                                        <td>{{ $translation->value_en }}</td>
                                        <td>{{ $translation->value_ru }}</td>
                                        <td>
                                            <span class="badge bg-{{ $translation->status ? 'success' : 'danger' }}">
                                                {{ $translation->status ? 'Aktiv' : 'Deaktiv' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('back.pages.translation-manage.edit', $translation->id) }}" class="btn btn-primary btn-sm waves-effect waves-light">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                            <!-- <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" onclick="deleteData({{ $translation->id }})">
                                                <i class="ri-delete-bin-line"></i>
                                            </button> -->
                                            <form id="delete-form-{{ $translation->id }}" action="{{ route('back.pages.translation-manage.destroy', $translation->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
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

@push('js')
<script>
    function deleteData(id) {
        Swal.fire({
            title: 'Əminsinizmi?',
            text: "Bu əməliyyatı geri ala bilməzsiniz!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Bəli, sil!',
            cancelButtonText: 'Xeyr'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }

    $(document).ready(function() {
        $('.table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
            }
        });
    });
</script>
@endpush