@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Report Post</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Request Post</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Report Post</li>
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
                        <span class="d-none d-md-block">Report Post</span>
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
                                        <h5 class="card-title fw-semibold">Report Posting </h5>
                                        <p class="card-subtitle mb-4">save the posting report here</p>
                                        @if ($existingReport)
                                            <div class="alert alert-info">
                                                Report already exists. You can view or edit the report below.
                                            </div>
                                            <form method="POST" enctype="multipart/form-data"
                                                action="{{ route('system.operator.request.posts.update', $existingReport->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="request_posting_id"
                                                    value="{{ $requestPostID }}">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-4">
                                                            <label for="report_title" class="form-label fw-semibold">Report
                                                                Title</label>
                                                            <input type="text" class="form-control" id="report_title"
                                                                name="report_title"
                                                                value="{{ $existingReport->report_title }}"
                                                                placeholder="Report Title">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-4">
                                                            <label for="report_content"
                                                                class="form-label fw-semibold">Report Content</label>
                                                            <textarea class="form-control" id="report_content" name="report_content" placeholder="Enter report content"
                                                                rows="4" maxlength="500">{{ $existingReport->report_content }}</textarea>
                                                            <small id="charCount" class="text-muted">Max 500
                                                                characters</small>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        const contentTextarea = document.getElementById('report_content');
                                                        const charCount = document.getElementById('charCount');
                                                        const maxLength = 500;

                                                        contentTextarea.addEventListener('input', function() {
                                                            const remaining = maxLength - contentTextarea.value.length;
                                                            charCount.textContent = `${remaining} characters remaining`;

                                                            if (remaining < 0) {
                                                                charCount.textContent = "Character limit exceeded!";
                                                                charCount.classList.add('text-danger');
                                                            } else {
                                                                charCount.classList.remove('text-danger');
                                                            }
                                                        });
                                                    </script>

                                                    <div class="col-12">
                                                        <div id="mediaContainer">
                                                            @foreach ($existingReport->mediaFiles as $mediaFile)
                                                                <div class="media-item mb-4">
                                                                    <label class="form-label fw-semibold">Existing Media:
                                                                        {{ $mediaFile->file_name }}</label>
                                                                    <a href="{{ asset('storage/' . $mediaFile->file_path) }}"
                                                                        target="_blank"
                                                                        class="btn btn-info btn-sm mt-2">View</a>
                                                                </div>
                                                            @endforeach
                                                            <div class="media-item mb-4">
                                                                <label for="mediaFiles"
                                                                    class="form-label fw-semibold">Upload Additional
                                                                    Media</label>
                                                                <input type="file" class="form-control media-file"
                                                                    name="mediaFiles[]"
                                                                    accept="image/*,video/*,.doc,.docx,.pdf">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm mt-2 remove-media">Delete</button>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-success mt-2"
                                                            id="addMedia">Add More Media</button>
                                                        <br>
                                                        <small class="form-text text-muted">Supported types: images,
                                                            videos, documents (max size 10MB each)</small>
                                                    </div>

                                                    <script>
                                                        const mediaContainer = document.getElementById('mediaContainer');
                                                        const addMediaButton = document.getElementById('addMedia');

                                                        addMediaButton.addEventListener('click', function() {
                                                            const newMediaItem = document.createElement('div');
                                                            newMediaItem.classList.add('media-item', 'mb-4');
                                                            newMediaItem.innerHTML = `
                            <input type="file" class="form-control media-file" name="mediaFiles[]" accept="image/*,video/*,.doc,.docx,.pdf">
                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-media">Delete</button>
                        `;
                                                            mediaContainer.appendChild(newMediaItem);

                                                            newMediaItem.querySelector('.remove-media').addEventListener('click', function() {
                                                                newMediaItem.remove();
                                                            });
                                                        });

                                                        mediaContainer.addEventListener('click', function(event) {
                                                            if (event.target.classList.contains('remove-media')) {
                                                                event.target.parentElement.remove();
                                                            }
                                                        });
                                                    </script>

                                                    <div class="col-12">
                                                        <div
                                                            class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                            <button type="button"
                                                                class="btn bg-danger-subtle text-danger">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            <form method="POST" enctype="multipart/form-data"
                                                action="{{ route('system.operator.request.posts.store') }}">
                                                @csrf
                                                <input type="hidden" name="request_posting_id"
                                                    value="{{ $requestPostID }}">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-4">
                                                            <label for="report_title"
                                                                class="form-label fw-semibold">Report Title</label>
                                                            <input type="text" class="form-control" id="report_title"
                                                                name="report_title" placeholder="Report Title">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-4">
                                                            <label for="report_content"
                                                                class="form-label fw-semibold">Report Content</label>
                                                            <textarea class="form-control" id="report_content" name="report_content" placeholder="Enter report content"
                                                                rows="4" maxlength="500"></textarea>
                                                            <small id="charCount" class="text-muted">Max 500
                                                                characters</small>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        const contentTextarea = document.getElementById('report_content');
                                                        const charCount = document.getElementById('charCount');
                                                        const maxLength = 500;

                                                        contentTextarea.addEventListener('input', function() {
                                                            const remaining = maxLength - contentTextarea.value.length;
                                                            charCount.textContent = `${remaining} characters remaining`;

                                                            if (remaining < 0) {
                                                                charCount.textContent = "Character limit exceeded!";
                                                                charCount.classList.add('text-danger');
                                                            } else {
                                                                charCount.classList.remove('text-danger');
                                                            }
                                                        });
                                                    </script>

                                                    <div class="col-12">
                                                        <div id="mediaContainer">
                                                            <div class="media-item mb-4">
                                                                <label for="mediaFiles"
                                                                    class="form-label fw-semibold">Upload Media</label>
                                                                <input type="file" class="form-control media-file"
                                                                    name="mediaFiles[]"
                                                                    accept="image/*,video/*,.doc,.docx,.pdf">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm mt-2 remove-media">Delete</button>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-success mt-2"
                                                            id="addMedia">Add More Media</button>
                                                        <br>
                                                        <small class="form-text text-muted">Supported types: images,
                                                            videos, documents (max size 10MB each)</small>
                                                    </div>

                                                    <script>
                                                        const mediaContainer = document.getElementById('mediaContainer');
                                                        const addMediaButton = document.getElementById('addMedia');

                                                        addMediaButton.addEventListener('click', function() {
                                                            const newMediaItem = document.createElement('div');
                                                            newMediaItem.classList.add('media-item', 'mb-4');
                                                            newMediaItem.innerHTML = `
                            <input type="file" class="form-control media-file" name="mediaFiles[]" accept="image/*,video/*,.doc,.docx,.pdf">
                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-media">Delete</button>
                        `;
                                                            mediaContainer.appendChild(newMediaItem);

                                                            newMediaItem.querySelector('.remove-media').addEventListener('click', function() {
                                                                newMediaItem.remove();
                                                            });
                                                        });

                                                        mediaContainer.addEventListener('click', function(event) {
                                                            if (event.target.classList.contains('remove-media')) {
                                                                event.target.parentElement.remove();
                                                            }
                                                        });
                                                    </script>

                                                    <div class="col-12">
                                                        <div
                                                            class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <button type="button"
                                                                class="btn bg-danger-subtle text-danger">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif

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
@endsection
