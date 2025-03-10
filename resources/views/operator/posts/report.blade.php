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
                                    <a class="text-muted text-decoration-none" href="/">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="/">Request Post</a>
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
                            <h5 class="card-title fw-semibold">Report Posting : {{ $requestPost->title }} </h5>
                            <p class="card-subtitle mb-4">save the posting report here</p>
                            <form method="POST"
                                action="{{ route('system.operator.request.posts.store', $requestPostID) }}">
                                @csrf
                                <input type="hidden" name="request_posting_id" value="{{ $requestPostID }}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-4">
                                            <label for="report_content" class="form-label fw-semibold">Report
                                                Content</label>
                                            <textarea class="form-control" id="report_content" name="report_content" placeholder="Enter report content"
                                                rows="6" maxlength="5000"></textarea>
                                            <small id="charCount" class="text-muted">Max 5000
                                                characters</small>
                                        </div>
                                    </div>

                                    <script>
                                        const contentTextarea = document.getElementById('report_content');
                                        const charCount = document.getElementById('charCount');
                                        const maxLength = 5000;

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
                                        <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <button type="button" class="btn bg-danger-subtle text-danger">Cancel</button>
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
@endsection
