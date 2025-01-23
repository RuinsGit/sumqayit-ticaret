@extends('back.layouts.master')

@section('title', 'Home About')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Home About</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Ana səhifə</a></li>
                            <li class="breadcrumb-item active">Home About</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 text-end">
                            <a href="{{ route('back.pages.home-about.create') }}" class="btn btn-primary {{ $homeAbouts->count() >= 1 ? 'disabled' : '' }}">
                                Yeni Əlavə Et
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Başlıq (AZ)</th>
                                        <th>Başlıq (EN)</th>
                                        <th>Başlıq (RU)</th>
                                        <th>Şəkillər</th>
                                        <th>Əməliyyatlar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($homeAbouts as $homeAbout)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $homeAbout->title1_az }}</td>
                                            <td>{{ $homeAbout->title1_en }}</td>
                                            <td>{{ $homeAbout->title1_ru }}</td>
                                            <td>
                                                @if($homeAbout->images)
                                                    @foreach(json_decode($homeAbout->images) as $image)
                                                        <img src="{{ asset($image) }}" alt="Image" width="50" height="50" class="me-1">
                                                    @endforeach
                                                @else
                                                    <span>Yüklənmiş şəkil yoxdur</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('back.pages.home-about.edit', $homeAbout->id) }}" class="btn btn-warning btn-sm">Dəyiş</a>
                                                <form action="{{ route('back.pages.home-about.destroy', $homeAbout->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Silmək istədiyinizdən əminsiniz?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($homeAbouts->isEmpty())
                            <p class="text-center">Home About üçün məlumat yoxdur.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
