@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Edit Request Post</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Request Post</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Edit Post</li>
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
        <div class="card">
            <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-4"
                        id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button"
                        role="tab" aria-controls="pills-account" aria-selected="true">
                        <i class="ti ti-file me-2 fs-6"></i>
                        <span class="d-none d-md-block">Edit Post</span>
                    </button>
                </li>
            </ul>
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-account" role="tabpanel"
                        aria-labelledby="pills-account-tab" tabindex="0">
                        <div class="row">
                            <div class="col-12">
                                <div class="card w-100 position-relative overflow-hidden mb-0">
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-semibold">Request Posting Details</h5>
                                        <p class="card-subtitle mb-4">Update the request posting details here</p>
                                        <form method="POST" enctype="multipart/form-data"
                                            action="{{ route('system.request.posts.update', $post->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-4">
                                                        <label for="total_account" class="form-label fw-semibold">Total
                                                            Account</label>
                                                        <input type="text" class="form-control" id="total_account"
                                                            name="total_account" value="{{ $post->total_account }}"
                                                            placeholder="Total Account">
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="user_id"
                                                            class="form-label fw-semibold">Operator</label>
                                                        <select name="user_id" id="user_id" class="form-control">
                                                            <option value="">Select Operator</option>
                                                            @foreach ($operators as $opr)
                                                                <option value="{{ $opr->id }}"
                                                                    {{ $post->user_id == $opr->id ? 'selected' : '' }}>
                                                                    {{ $opr->full_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-4">
                                                        <label for="title" class="form-label fw-semibold">Title</label>
                                                        <input type="text" class="form-control" id="title"
                                                            name="title" value="{{ $post->title }}"
                                                            placeholder="Post Title">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="social_media_platform_id"
                                                            class="form-label fw-semibold">Social Media Platform</label>
                                                        <select name="social_media_platform_id"
                                                            id="social_media_platform_id" class="form-control">
                                                            <option value="">Select Social Media Platform</option>
                                                            @foreach ($socialMedias as $smp)
                                                                <option value="{{ $smp->id }}"
                                                                    {{ $post->social_media_platform_id == $smp->id ? 'selected' : '' }}>
                                                                    {{ $smp->social_media_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-4">
                                                        <label for="content" class="form-label fw-semibold">Content</label>
                                                        <textarea class="form-control" id="content" name="content" placeholder="please input ur content" rows="4">{{ $post->content }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div id="mediaContainer">
                                                        @foreach ($post->mediaFiles as $media)
                                                            <div class="media-item mb-4" id="media-{{ $media->id }}">
                                                                <label class="form-label fw-semibold">Existing
                                                                    Media</label><br>
                                                                <input type="hidden" name="existingMedia[]"
                                                                    value="{{ $media->id }}">
                                                                <a href="/storage/{{ $media->file_path }}"
                                                                    target="_blank">{{ $media->file_path }}</a><br>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm mt-2 remove-media"
                                                                    data-media-id="{{ $media->id }}">Delete</button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button type="button" class="btn btn-success mt-2"
                                                        id="addMedia">Add More Media</button>
                                                    <br>
                                                    <small class="form-text text-muted">Supported types: images, videos,
                                                        documents (max size 10MB each)</small>
                                                </div>


                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <a href="{{ route('system.request.posts.index') }}"
                                                            class="btn bg-danger-subtle text-danger">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    {{-- <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Write your post content here...'
        });

        document.querySelector('form').onsubmit = function() {
            var content = quill.root.innerHTML;
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'content';
            hiddenInput.value = content;

            this.appendChild(hiddenInput);

            return true;
        };
    </script> --}}

    <script>
        document.getElementById('addMedia').addEventListener('click', function() {
            const mediaContainer = document.getElementById('mediaContainer');
            const newMedia = document.createElement('div');
            newMedia.classList.add('media-item', 'mb-4');
            newMedia.innerHTML = `
                <label class="form-label fw-semibold">Upload Media</label>
                <input type="file" class="form-control media-file" name="mediaFiles[]" accept="image/*,video/*,.doc,.docx,.pdf">
                <button type="button" class="btn btn-danger btn-sm mt-2 remove-media">Delete</button>
            `;
            mediaContainer.appendChild(newMedia);
            newMedia.querySelector('.remove-media').addEventListener('click', function() {
                newMedia.remove();
            });
        });
        document.querySelectorAll('.remove-media').forEach(function(button) {
            button.addEventListener('click', function() {
                button.closest('.media-item').remove();
            });
        });
    </script>

    <script>
        document.querySelectorAll('.remove-media').forEach(function(button) {
            button.addEventListener('click', function() {
                var mediaId = button.getAttribute('data-media-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`/media/${mediaId}`, {
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(function(response) {
                                if (response.data.message === 'Media deleted successfully') {
                                    document.getElementById(`media-${mediaId}`).remove();
                                    toastr.success('Media deleted successfully');
                                }
                            })
                            .catch(function(error) {
                                console.error('Error:', error);
                                toastr.error('Failed to delete media.');
                            });
                    }
                });
            });
        });
    </script>
@endsection
