@extends('back.layouts.master')

@section('title', 'Kirayə Tələbləri')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Kirayə Tələbləri</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item active">Kirayə Tələbləri</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Kirayə Tələbləri Siyahısı</h4>

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ad</th>
                                            <th>Marka adı</th>
                                            <th>E-poçt</th>
                                            <th>Telefon</th>
                                            <th>Anbar</th>
                                            <th>Tələb olunan sahə</th>
                                            <th>Mesaj</th>
                                            <th>Əməliyyatlar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contacts as $contact)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ $contact->brand_name }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ $contact->phone_prefix }} {{ $contact->phone_number }}</td>
                                            <td>{{ $contact->warehouse }}</td>
                                            <td>{{ $contact->requested_area }}</td>
                                            <td>
                                                <div style="max-height: 100px; overflow: auto;">
                                                    {!! $contact->message !!}
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('back.pages.contact-rent.show', $contact->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('back.pages.contact-rent.destroy', $contact->id) }}" method="POST" class="d-inline-block">
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

                            {{ $contacts->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 