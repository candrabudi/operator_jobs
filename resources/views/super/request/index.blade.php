@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Request Post</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="{{ route('system.dashboard.index') }}">Dashboard</a>
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
        <div class="widget-content searchable-container list">
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-4 col-xl-3">
                        <form class="position-relative">
                            <input type="text" class="form-control product-search ps-5" id="input-search"
                                placeholder="Search Request Posts...">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div
                        class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <a href="{{ route('system.request.posts.create') }}" class="btn btn-sm btn-info d-flex align-items-center">
                            Add Request Post
                        </a>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>Trx Post</th>
                                <th>Title</th>
                                <th>Total Media</th>
                                <th>Social Media</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="request-table-body">

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
    <script>
        const platformTableBody = document.getElementById('request-table-body');
        const paginationNav = document.getElementById('pagination').querySelector('ul');

        function getPageFromUrl(url) {
            const match = url ? url.match(/page=(\d+)/) : null;
            return match ? match[1] : 1;
        }

        function buildPlatformTable(data) {
            let rows = '';
            data.forEach(platform => {
                const mediaCount = platform.request_media_posts.length;
                const mediaType = platform.request_media_posts.map(media => media.file_type).join(', ');

                rows += `
                    <tr class="search-items">
                        <td>${platform.trx_post}</td>
                        <td>${platform.title}</td>
                        <td>${mediaCount} (${mediaType})</td>
                        <td>${platform.platform.social_media_name}</td>
                        <td>${platform.status}</td>
                        <td>
                            <div class="action-btn">
                                <a href="/system/request/posts/${platform.id}/edit" class="text-info edit" onclick="editPlatform(${platform.id})">
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
            axios.get(`/system/request/posts/list?page=${page}`)
                .then(response => {
                    const {
                        data,
                        current_page: currentPage,
                        links: paginationLinks
                    } = response.data;

                    platformTableBody.innerHTML = buildPlatformTable(data);
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
                    axios.delete(`/system/request/posts/${userId}/destroy`)
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

        fetchPlatforms();
    </script>
@endsection
