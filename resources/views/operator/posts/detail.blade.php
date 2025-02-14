@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Detail Request Post</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none"
                                        href="{{ route('system.dashboard.index') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Request Post</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('images/breadcrumb/ChatBc.png') }}" alt="" class="img-fluid mb-n4">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shop-detail">
            <div class="card shadow-none border">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Looping untuk media file -->
                            <div>
                                @foreach ($posts->mediaFiles as $media)
                                    <div class="mb-3">
                                        <!-- Hanya tombol download, tidak ada preview -->
                                        <h6>Media File: {{ $media->file_name }}</h6>
                                        <a href="{{ asset('storage/' . $media->file_path) }}" download
                                            class="btn btn-primary">Download</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="shop-content">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge text-bg-success fs-2 fw-semibold rounded-3">{{ $posts->total_account }}
                                        Akun</span>
                                    <span class="fs-2">{{ $posts->platform->social_media_name }}</span>
                                </div>
                                <h4 class="fw-semibold">Title: {{ $posts->title }}</h4>
                                <h6 class="fw-semibold">Operator: {{ $posts->user->full_name }}</h6>
                                <h6 class="fw-semibold">Created At: {{ \Carbon\Carbon::parse($posts->created_at)->locale('id')->isoFormat('D MMMM Y, H:mm') }}</h6>
                                <h6>Content</h6>
                                <p>{{ $posts->content }}</p>
                                <div class="d-sm-flex align-items-center gap-3 pt-8 mb-7">
                                    <button class="btn btn-primary" id="process-button" data-post-id="{{ $posts->id }}">
                                        Process Post
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#process-button').click(function() {
                var postId = $(this).data('post-id');

                $.ajax({
                    url: '/update-status/' + postId,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#post-status').text('process');
                            alert(response.message);
                        } else {
                            alert('Failed to update post status');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Something went wrong');
                    }
                });
            });
        });
    </script>
@endsection
