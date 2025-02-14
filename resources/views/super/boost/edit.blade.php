@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Edit Request Boost</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Request Boost</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Edit Boost</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
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
                        <span class="d-none d-md-block">Edit Boost</span>
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
                                        <h5 class="card-title fw-semibold">Request Boosting Details</h5>
                                        <p class="card-subtitle mb-4">Update the boost request details here</p>
                                        <form id="boostForm" method="POST" enctype="multipart/form-data"
                                            action="{{ route('system.request.boosts.update', $boost->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-4">
                                                        <label for="user_id"
                                                            class="form-label fw-semibold">Operator</label>
                                                        <select name="user_id" id="user_id" class="form-control">
                                                            <option value="">Select Operator</option>
                                                            @foreach ($operators as $opr)
                                                                <option value="{{ $opr->id }}"
                                                                    {{ $opr->id == $boost->user_id ? 'selected' : '' }}>
                                                                    {{ $opr->full_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">Please select an operator.</div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="qty"
                                                            class="form-label fw-semibold">Quantity</label>
                                                        <input type="number" class="form-control" id="qty"
                                                            name="qty" placeholder="Enter Quantity"
                                                            value="{{ $boost->qty }}" min="1">
                                                        <div class="invalid-feedback">Please provide a valid quantity
                                                            (greater than 0).</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-4">
                                                        <label for="social_media_platform_id" class="form-label fw-semibold">Social Media Platform</label>
                                                        <select name="social_media_platform_id" id="social_media_platform_id" class="form-control">
                                                            <option value="">Select Social Media Platform</option>
                                                            @foreach ($socialMedias as $smp)
                                                                <option value="{{ $smp->id }}" {{ $smp->id == $boost->social_media_platform_id ? 'selected' : '' }}>
                                                                    {{ $smp->social_media_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">Please select a social media platform.</div>
                                                    </div>
                                                
                                                    <div class="mb-4">
                                                        <label for="social_media_platform_limit_id" class="form-label fw-semibold">Boosting Limit</label>
                                                        <select name="social_media_platform_limit_id" id="social_media_platform_limit_id" class="form-control">
                                                            <option value="">Select Boosting Limit</option>
                                                        </select>
                                                        <div class="invalid-feedback">Please select a boosting limit.</div>
                                                    </div>
                                                
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            const platformSelect = document.getElementById('social_media_platform_id');
                                                            const limitSelect = document.getElementById('social_media_platform_limit_id');
                                                            const selectedPlatformId = "{{ $boost->social_media_platform_id }}";
                                                            const selectedLimitId = "{{ $boost->social_media_platform_limit_id }}";
                                                
                                                            async function fetchBoostLimits(platformId) {
                                                                limitSelect.innerHTML = '<option value="">Select Boosting Limit</option>';
                                                                if (platformId) {
                                                                    try {
                                                                        const response = await fetch('/get-boost-limits/' + platformId);
                                                                        if (!response.ok) {
                                                                            throw new Error('Failed to fetch boost limits');
                                                                        }
                                                                        const data = await response.json();
                                                                        data.forEach(function(limit) {
                                                                            var option = document.createElement('option');
                                                                            option.value = limit.id;
                                                                            option.setAttribute('data-platform-type', limit.platform_type);
                                                                            option.text = limit.platform_type + ' (Min: ' + limit.min + ', Max: ' + limit.max + ')';
                                                                            if (limit.id == selectedLimitId) {
                                                                                option.selected = true;
                                                                            }
                                                                            limitSelect.appendChild(option);
                                                                        });
                                                                    } catch (error) {
                                                                        console.error('Error fetching boost limits:', error);
                                                                    }
                                                                }
                                                            }
                                                
                                                            platformSelect.addEventListener('change', function() {
                                                                fetchBoostLimits(this.value);
                                                            });
                                                
                                                            if (selectedPlatformId) {
                                                                // Automatically trigger the change event on page load if a platform is selected
                                                                fetchBoostLimits(selectedPlatformId);
                                                            }
                                                        });
                                                    </script>
                                                </div>
                                                

                                                <div class="col-lg-12">
                                                    <div class="mb-4">
                                                        <label for="link_post" class="form-label fw-semibold">Post
                                                            Link</label>
                                                        <input type="url" class="form-control" id="link_post"
                                                            name="link_post" placeholder="Enter Post Link"
                                                            value="{{ $boost->link_post }}">
                                                        <div class="invalid-feedback">Please provide a valid URL.</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-4">
                                                        <label for="content" class="form-label fw-semibold">Notes</label>
                                                        <textarea name="content" rows="4" class="form-control" id="">{{ $boost->content }}</textarea>
                                                        <div class="invalid-feedback">Content is required.</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-4" id="comment_section"
                                                        style="{{ $boost->comment ? 'display: block;' : 'display: none;' }}">
                                                        <label for="comment"
                                                            class="form-label fw-semibold">Comment</label>
                                                        <textarea name="comment" rows="4" class="form-control">{{ $boost->comment }}</textarea>
                                                        <div class="invalid-feedback">Comment is required.</div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <a href="{{ route('system.request.boosts.index') }}"
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

    <script>
        document.getElementById('social_media_platform_limit_id').addEventListener('change', function() {
            var selectedPlatform = this.options[this.selectedIndex];
            var platformType = selectedPlatform.getAttribute('data-platform-type');
            var commentSection = document.getElementById('comment_section');

            if (platformType === 'comment') {
                commentSection.style.display = 'block';
            } else {
                commentSection.style.display = 'none';
            }
        });
    </script>
@endsection
