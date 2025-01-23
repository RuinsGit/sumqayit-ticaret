@extends('back.layouts.master')
@section('title', 'Sosial Media')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Sosial Media</h4>

                        <div class="page-title-right">
                            <a href="{{ route('back.pages.social.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Yeni əlavə et
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <table class="table table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Sıra</th>
                                        <th>Şəkil</th>
                                        <th>Link</th>
                                        <th>Status</th>
                                        <th>Əməliyyatlar</th>
                                    </tr>
                                </thead>
                                <tbody class="sortable" data-url="{{ route('back.pages.social.order') }}">
                                    @foreach($socials as $social)
                                        <tr id="order-{{ $social->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ asset($social->image) }}" alt="" style="height: 50px; width: 50px; object-fit: cover; ">
                                            </td>
                                            <td>{{ $social->link }}</td>
                                            <td>
                                                <form action="{{ route('back.pages.social.toggle-status', $social->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-{{ $social->status ? 'success' : 'danger' }}">
                                                        {{ $social->status ? 'Aktiv' : 'Deaktiv' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('back.pages.social.edit', $social->id) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('back.pages.social.destroy', $social->id) }}" 
                                                      method="POST" 
                                                      class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Silmək istədiyinizə əminsiniz?')">
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
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $('.sortable').sortable({
                handle: 'tr',
                update: function() {
                    let siralama = $('.sortable').sortable('serialize');
                    let url = $('.sortable').data('url');
                    $.post(url, {order: siralama}, function(response) {});
                }
            });
        });

        function toggleStatus(socialId) {
            Swal.fire({
                title: 'Statusu dəyişmək istədiyinizdən əminsiniz?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bəli',
                cancelButtonText: 'Xeyr'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch(`/admin/pages/social/toggle-status/${socialId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Status dəyişdirilə bilmədi.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: error.message || 'Bir problem yaşandı.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
                }
            });
        }
    </script>
@endsection