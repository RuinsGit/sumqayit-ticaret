@extends('back.layouts.master')

@section('title', 'Sosial Media')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sosial Media</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Panel</a></li>
                        <li class="breadcrumb-item active">Sosial Media</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('back.pages.socialshare.create') }}" class="btn btn-primary">Yeni Sosial Media</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 50px">ID</th>
                                <th>Ad</th>
                                <th>İkon</th>
                                <th>Link</th>
                                <th>Sıra</th>
                                <th>Status</th>
                                <th style="width: 200px">Əməliyyatlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($socialshares as $socialshare)
                            <tr>
                                <td>{{ $socialshare->id }}</td>
                                <td>{{ $socialshare->name }}</td>
                                <td>
                                    @if($socialshare->image)
                                        <img src="{{ asset($socialshare->image) }}" alt="{{ $socialshare->name }}" style="max-height: 30px;">
                                    @else
                                        <span class="text-muted">Şəkil yoxdur</span>
                                    @endif
                                </td>
                                <td>{{ $socialshare->link }}</td>
                                <td>{{ $socialshare->order }}</td>
                                <td>
                                    @if($socialshare->status)
                                        <span class="badge badge-success">Aktiv</span>
                                    @else
                                        <span class="badge badge-danger">Deaktiv</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('back.pages.socialshare.edit', $socialshare->id) }}" class="btn btn-sm btn-warning">Düzəliş et</a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteSocialshare({{ $socialshare->id }})">Sil</button>
                                    <form id="delete-form-{{ $socialshare->id }}" action="{{ route('back.pages.socialshare.destroy', $socialshare->id) }}" method="POST" style="display: none;">
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
@endsection

@push('js')
<script>
    function deleteSocialshare(id) {
        if (confirm('Silmək istədiyinizə əminsiniz?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush 