@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Request Boost</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none"
                                        href="{{ route('system.dashboard.index') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Request Boost</li>
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
                                placeholder="Search Request Boosts...">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>Link Post</th>
                                <th>Like Count</th>
                                <th>Comment Count</th>
                                <th>View Count</th>
                                <th>Social Media</th>
                                <th>Engagement Type</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="request-table-body">

                        </tbody>
                    </table>

                    <nav id="pagination" aria-label="Page navigation">
                        <ul class="pagination">

                        </ul>
                    </nav>


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
                let createdAt = new Date(platform.created_at).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                let updatedAt = new Date(platform.updated_at).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                let statusBadge;
                switch (platform.status) {
                    case 'pending':
                        statusBadge = '<span class="badge bg-warning">Pending</span>';
                        break;
                    case 'completed':
                        statusBadge = '<span class="badge bg-success">Completed</span>';
                        break;
                    default:
                        statusBadge = '<span class="badge bg-secondary">' + platform.status + '</span>';
                }

                let actionButtons = '';

                if (platform.status === 'pending') {
                    actionButtons = `
                        <button class="btn btn-sm btn-success d-flex align-items-center gap-1" onclick="markAsCompleted(${platform.id})">
                            <i class="ti ti-check fs-6"></i> Completed
                        </button>
                    `;
                } else {
                    actionButtons = '-';
                }

                const shortenedLink = platform.link_post.length > 30 
                ? platform.link_post.substring(0, 30) + '...' 
                : platform.link_post;
                rows += `
                    <tr class="search-items">
                        <td><a href="${platform.link_post}" target="_blank">${shortenedLink}</a></td>
                        <td>${platform.like_count}</td>
                        <td>${platform.comment_count}</td>
                        <td>${platform.view_count}</td>
                        <td>${platform.platform.social_media_name}</td>
                        <td>${platform.engagement.engagement_type}</td>
                        <td>${statusBadge}</td>
                        <td>${createdAt}</td>
                        <td>${updatedAt}</td>
                        <td>
                            <div class="action-btn d-flex gap-2">
                                ${actionButtons}
                            </div>
                        </td>
                    </tr>
                `;
            });
            return rows;
        }

        function markAsCompleted(platformId) {
            alert(`Marking platform ID ${platformId} as completed`);
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
            axios.get(`/system/operator/request/boosts/list?page=${page}`)
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

        fetchPlatforms();
    </script>
@endsection
