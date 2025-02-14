@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Social Media Platforms</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Social Media Platforms</li>
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
        <div class="widget-content searchable-container list">
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-4 col-xl-3">
                        <form class="position-relative">
                            <input type="text" class="form-control product-search ps-5" id="input-search"
                                placeholder="Search Platforms...">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div
                        class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <a href="javascript:void(0)" id="btn-add-platform"
                            class="btn btn-sm btn-info d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#addPlatformModal">
                            <i class="ti ti-plus text-white me-1 fs-5"></i> Add Platform
                        </a>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>Platform Name</th>
                                <th>Description</th>
                                <th>Limits</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody id="platform-table-body">

                        </tbody>
                    </table>

                    <nav id="pagination" aria-label="Page navigation">
                        <ul class="pagination pagination-sm">

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPlatformModal" tabindex="-1" aria-labelledby="addPlatformModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPlatformModalLabel">Add Social Media Platform</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="platformForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Platform Name</label>
                            <input type="text" name="social_media_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Platform Limits</label>
                            <div id="limit-container">
                                <div class="limit-row mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <label for="platform_type[]" class="form-label">Boost Type</label>
                                            <select name="platform_type[]" class="form-control">
                                                <option value="like">Like</option>
                                                <option value="comment">Comment</option>
                                                <option value="view">View</option>
                                                <option value="share">Share</option>
                                                <option value="subscribe">Subscribe</option>
                                                <option value="follow">Follow</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="min_value[]" class="form-label">Min Value</label>
                                            <input type="number" name="min[]" class="form-control" value="1">
                                        </div>
                                        <div class="col">
                                            <label for="max_value[]" class="form-label">Max Value</label>
                                            <input type="number" name="max[]" class="form-control" value="1000">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Action</label>
                                            <button type="button" class="btn btn-danger remove-limit">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="add-limit">Add Limit</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Platform</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPlatformModal" tabindex="-1" aria-labelledby="editPlatformModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPlatformModalLabel">Edit Social Media Platform</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPlatformForm">
                        @csrf
                        <input type="hidden" id="edit_platform_id" name="platform_id">

                        <div class="mb-3">
                            <label for="edit_social_media_name" class="form-label">Platform Name</label>
                            <input type="text" id="edit_social_media_name" name="social_media_name"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea id="edit_description" name="description" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Platform Limits</label>
                            <div id="limit-container-edit"></div>
                            <button type="button" class="btn btn-primary" id="add-limit-edit">Add Limit</button>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Platform</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const platformTableBody = document.getElementById('platform-table-body');
        const paginationNav = document.getElementById('pagination').querySelector('ul');

        function getPageFromUrl(url) {
            const match = url ? url.match(/page=(\d+)/) : null;
            return match ? match[1] : 1;
        }

        function buildPlatformTable(platforms) {
            let rows = '';
            platforms.forEach(platform => {
                const limits = platform.limits.map(limit => `
                    <div>${limit.platform_type}: ${limit.min} - ${limit.max}</div>
                `).join('');

                rows += `
                    <tr class="search-items">
                        <td>${platform.social_media_name}</td>
                        <td>${platform.description || 'No description'}</td>
                        <td>${limits}</td>
                        <td>
                            <div class="action-btn">
                                <a href="javascript:void(0)" class="text-info edit" onclick="editPlatform(${platform.id})">
                                    <i class="ti ti-pencil fs-5"></i> Edit
                                </a>
                                <a href="javascript:void(0)" class="text-dark delete ms-2" onclick="deletePlatform(${platform.id})">
                                    <i class="ti ti-trash fs-5"></i> Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            });
            return rows;
        }

        function buildPaginationLinks(paginationLinks, currentPage) {
            let paginationHtml = '';
            paginationLinks.forEach(link => {
                paginationHtml += `
                    <li class="page-item ${link.active ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0)" onclick="fetchPlatforms(${getPageFromUrl(link.url) || currentPage})">
                            ${link.label}
                        </a>
                    </li>
                `;
            });
            return paginationHtml;
        }

        function fetchPlatforms(page = 1) {
            axios.get(`/system/platforms/list?page=${page}`)
                .then(response => {
                    const {
                        data: platforms,
                        current_page: currentPage,
                        links: paginationLinks
                    } = response.data;
                    platformTableBody.innerHTML = buildPlatformTable(platforms);
                    paginationNav.innerHTML = buildPaginationLinks(paginationLinks, currentPage);
                })
                .catch(error => {
                    console.error('Error fetching platforms:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch platform data.',
                    });
                });
        }

        function deletePlatform(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this user!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then(result => {
                if (result.isConfirmed) {
                    axios.delete(`/system/platforms/${userId}/destroy`)
                        .then(response => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Platform has been deleted.'
                            });
                            fetchPlatforms();
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to delete user.'
                            });
                            console.error('Error deleting user:', error);
                        });
                }
            });
        }

        document.getElementById('platformForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            axios.post("/system/platforms/store", formData)
                .then(function(response) {
                    if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Create!',
                            text: 'Platform has been created.'
                        });
                        $('#addPlatformModal').modal('hide');
                        document.getElementById('platformForm').reset();
                        document.getElementById('limit-container').innerHTML = '';
                        fetchPlatforms();
                    }
                })
                .catch(function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to add platform. Please try again.',
                    });
                });
        });

        const limitContainer = document.getElementById('limit-container-edit');
        const addLimitButton = document.getElementById('add-limit-edit');

        function createLimitRow(limit = {}) {
            const limitRow = document.createElement('div');
            limitRow.classList.add('limit-row', 'mb-3');
            limitRow.innerHTML = `
            <div class="row">
                <div class="col">
                    <label for="platform_type[]" class="form-label">Boost Type</label>
                    <select name="platform_type[]" class="form-control">
                        <option value="like" ${limit.platform_type === 'like' ? 'selected' : ''}>Like</option>
                        <option value="comment" ${limit.platform_type === 'comment' ? 'selected' : ''}>Comment</option>
                        <option value="view" ${limit.platform_type === 'view' ? 'selected' : ''}>View</option>
                        <option value="share" ${limit.platform_type === 'share' ? 'selected' : ''}>Share</option>
                        <option value="subscribe" ${limit.platform_type === 'subscribe' ? 'selected' : ''}>Subscribe</option>
                        <option value="follow" ${limit.platform_type === 'follow' ? 'selected' : ''}>Follow</option>
                    </select>
                </div>
                <div class="col">
                    <label for="min[]" class="form-label">Min Value</label>
                    <input type="number" name="min[]" class="form-control" value="${limit.min || 1}">
                </div>
                <div class="col">
                    <label for="max[]" class="form-label">Max Value</label>
                    <input type="number" name="max[]" class="form-control" value="${limit.max || 1000}">
                </div>
                <div class="col">
                    <label class="form-label">Action</label>
                    <button type="button" class="btn btn-danger remove-limit">Remove</button>
                </div>
            </div>
            `;
            limitRow.querySelector('.remove-limit').addEventListener('click', function() {
                limitRow.remove();
            });
            return limitRow;
        }

        addLimitButton.addEventListener('click', function() {
            const newLimitRow = createLimitRow();
            limitContainer.appendChild(newLimitRow);
        });

        function populateLimits(limits) {
            limitContainer.innerHTML = '';
            limits.forEach(limit => {
                const limitRow = createLimitRow(limit);
                limitContainer.appendChild(limitRow);
            });
        }

        document.getElementById('editPlatformForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const platformId = document.getElementById('edit_platform_id').value;
            const formData = new FormData(this);

            axios.post(`/system/platforms/${platformId}/update`, formData)
                .then(response => {
                    if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Success update platform',
                        });
                        $('#editPlatformModal').modal('hide');
                        document.getElementById('editPlatformForm').reset();
                        limitContainer.innerHTML = '';
                        fetchPlatforms(); // Assuming this refreshes the platform list
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update platform.',
                    });
                });
        });

        window.editPlatform = function(platformId) {
            axios.get(`/system/platforms/${platformId}/edit`)
                .then(response => {
                    const platform = response.data.platform;
                    document.getElementById('edit_platform_id').value = platform.id;
                    document.getElementById('edit_social_media_name').value = platform.social_media_name;
                    document.getElementById('edit_description').value = platform.description;
                    populateLimits(platform.limits);

                    $('#editPlatformModal').modal('show');
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch platform data.',
                    });
                });
        };

        fetchPlatforms();
    </script>


    <script>
        document.getElementById('add-limit').addEventListener('click', function() {
            const limitContainer = document.getElementById('limit-container');
            const newLimitRow = document.createElement('div');
            newLimitRow.classList.add('limit-row', 'mb-3');

            newLimitRow.innerHTML = `
                <div class="row">
                    <div class="col">
                        <label for="platform_type[]" class="form-label">Boost Type</label>
                        <select name="platform_type[]" class="form-control">
                            <option value="like">Like</option>
                            <option value="comment">Comment</option>
                            <option value="view">View</option>
                            <option value="share">Share</option>
                            <option value="subscribe">Subscribe</option>
                            <option value="follow">Follow</option>
                            <option value="comment">Comment</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="min_value[]" class="form-label">Min Value</label>
                        <input type="number" name="min_value[]" class="form-control" value="1">
                    </div>
                    <div class="col">
                        <label for="max_value[]" class="form-label">Max Value</label>
                        <input type="number" name="max_value[]" class="form-control" value="1000">
                    </div>
                    <div class="col">
                        <label class="form-label">Action</label>
                        <button type="button" class="btn btn-danger remove-limit">Remove</button>
                    </div>
                </div>
            `;

            limitContainer.appendChild(newLimitRow);
            newLimitRow.querySelector('.remove-limit').addEventListener('click', function() {
                limitContainer.removeChild(newLimitRow);
            });
        });

        document.querySelectorAll('.remove-limit').forEach(function(button) {
            button.addEventListener('click', function() {
                const limitRow = button.closest('.limit-row');
                limitRow.parentElement.removeChild(limitRow);
            });
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const limitContainer = document.getElementById('limit-container-edit');
            const addLimitButton = document.getElementById('add-limit-edit');
            addLimitButton.addEventListener('click', function() {
                const limitRow = document.createElement('div');
                limitRow.classList.add('limit-row', 'mb-3');
                limitRow.innerHTML = `
                <div class="row">
                    <div class="col">
                        <label for="platform_type[]" class="form-label">Boost Type</label>
                        <select name="platform_type[]" class="form-control">                            <option value="view">View</option>
                            <option value="share">Share</option>
                            <option value="subscribe">Subscribe</option>
                            <option value="follow">Follow</option>
                            <option value="comment">Comment</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="min[]" class="form-label">Min Value</label>
                        <input type="number" name="min[]" class="form-control" value="1">
                    </div>
                    <div class="col">
                        <label for="max[]" class="form-label">Max Value</label>
                        <input type="number" name="max[]" class="form-control" value="1000">
                    </div>
                    <div class="col">
                        <label class="form-label">Action</label>
                        <button type="button" class="btn btn-danger remove-limit">Remove</button>
                    </div>
                </div>
            `;
                limitContainer.appendChild(limitRow);
                limitRow.querySelector('.remove-limit').addEventListener('click', function() {
                    limitRow.remove();
                });
            });
            document.querySelectorAll('.remove-limit').forEach(function(button) {
                button.addEventListener('click', function() {
                    this.closest('.limit-row').remove();
                });
            });
        });
    </script> --}}
@endsection
