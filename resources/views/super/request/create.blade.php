@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Create Request Post</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Request Post</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Create Post</li>
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
                        <span class="d-none d-md-block">Create Post</span>
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
                                        <p class="card-subtitle mb-4">save the request posting details here</p>
                                        <form method="POST" enctype="multipart/form-data"
                                            action="{{ route('system.request.posts.store') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-4">
                                                        <label for="total_account" class="form-label fw-semibold">Total
                                                            Account</label>
                                                        <input type="text" class="form-control" id="total_account"
                                                            name="total_account" placeholder="Total Account">
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="user_id"
                                                            class="form-label fw-semibold">Operator</label>
                                                        <select name="user_id" id="user_id" class="form-control">
                                                            <option value="">Select Operator</option>
                                                            @foreach ($operators as $opr)
                                                                <option value="{{ $opr->id }}">{{ $opr->full_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-4">
                                                        <label for="title" class="form-label fw-semibold">Title</label>
                                                        <input type="text" class="form-control" id="title"
                                                            name="title" placeholder="Post Title">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="social_media_platform_id"
                                                            class="form-label fw-semibold">Social Media Platform</label>
                                                        <select name="social_media_platform_id"
                                                            id="social_media_platform_id" class="form-control">
                                                            <option value="">Select Social Media Platform</option>
                                                            @foreach ($socialMedias as $smp)
                                                                <option value="{{ $smp->id }}">
                                                                    {{ $smp->social_media_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="mb-4">
                                                        <label for="content" class="form-label fw-semibold">Content</label>
                                                        <textarea class="form-control" id="content" name="content" placeholder="Please input your content" rows="4"
                                                            maxlength="150"></textarea>
                                                        <small id="charCount" class="text-muted">Max 150 characters</small>
                                                    </div>
                                                </div>

                                                <script>
                                                    const contentTextarea = document.getElementById('content');
                                                    const charCount = document.getElementById('charCount');
                                                    const saveButton = document.querySelector('button[type="submit"]');
                                                    const maxLength = 150;

                                                    contentTextarea.addEventListener('input', function() {
                                                        const remaining = maxLength - contentTextarea.value.length;
                                                        charCount.textContent = `${remaining} characters remaining`;

                                                        if (remaining < 0) {
                                                            charCount.textContent = "Character limit exceeded!";
                                                            charCount.classList.add('text-danger');
                                                            saveButton.disabled = true;
                                                        } else {
                                                            charCount.classList.remove('text-danger');
                                                            saveButton.disabled = false;
                                                        }
                                                    });
                                                </script>

                                                <div class="col-12">
                                                    <div id="mediaContainer">
                                                        <div class="media-item mb-4">
                                                            <label for="mediaFiles" class="form-label fw-semibold">Upload
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
                                                    <small class="form-text text-muted">Supported types: images, videos,
                                                        documents (max size 10MB each)</small>
                                                </div>

                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <button type="button"
                                                            class="btn bg-danger-subtle text-danger">Cancel</button>
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
