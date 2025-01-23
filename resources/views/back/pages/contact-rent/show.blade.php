@extends('back.layouts.master')

@section('title', 'Kirayə Tələbi Detalları')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Kirayə Tələbi Detalları</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('back.pages.contact-rent.index') }}">Kirayə Tələbləri</a></li>
                                <li class="breadcrumb-item active">Detal</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <th width="200">Ad</th>
                                            <td>{{ $contact->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Marka adı</th>
                                            <td>{{ $contact->brand_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>E-poçt</th>
                                            <td>{{ $contact->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telefon</th>
                                            <td>{{ $contact->phone_prefix }} {{ $contact->phone_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Anbar</th>
                                            <td>{{ $contact->warehouse }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tələb olunan sahə</th>
                                            <td>{{ $contact->requested_area }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mesaj</th>
                                            <td>{!! $contact->message !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Yaradılma tarixi</th>
                                            <td>{{ $contact->created_at ? $contact->created_at->format('d.m.Y H:i') : 'Məlumat yoxdur' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('back.pages.contact-rent.index') }}" class="btn btn-primary">Geri qayıt</a>
                                <form action="{{ route('back.pages.contact-rent.destroy', $contact->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Silmək istədiyinizə əminsiniz?')">
                                        Sil
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 