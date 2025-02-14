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
                                    <a class="text-muted text-decoration-none" href="{{ route('system.dashboard.index') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Request Boost</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('images/breadcrumb/BoostIcon.png') }}" alt="" class="img-fluid mb-n4">
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
                            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div
                        class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <a href="{{ route('system.request.boosts.create') }}" class="btn btn-sm btn-info d-flex align-items-center">
                            Add Request Boost
                        </a>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>Trx Boost</th>
                                <th>Link Post</th>
                                <th>Social Media</th>
                                <th>Platform Type</th>
                                <th>Quantity</th>
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
        const boostTableBody = document.getElementById('request-table-body');
        const paginationNav = document.getElementById('pagination').querySelector('ul');

        function getPageFromUrl(url) {
            const match = url ? url.match(/page=(\d+)/) : null;
            return match ? match[1] : 1;
        }

        function buildBoostTable(data) {
            let rows = '';
            data.forEach(boost => {
                const platform = boost.social_media_platform.social_media_name;
                const platformType = boost.social_media_platform_limit.platform_type;
                const qty = boost.qty;

                rows += `
                    <tr class="search-items">
                        <td>${boost.trx_boost}</td>
                        <td><a href="${boost.link_post}" target="_blank"> Open Link</a></td>
                        <td>${platform}</td>
                        <td>${platformType}</td>
                        <td>${qty}</td>
                        <td>${boost.status}</td>
                        <td>
                            <div class="action-btn">
                                <a href="/system/request/boosts/${boost.id}/edit" class="text-info edit" onclick="editBoost(${boost.id})">
                                    <i class="ti ti-pencil fs-5"></i> Edit
                                </a>
                                <a href="javascript:void(0)" class="text-dark delete ms-2" onclick="deleteBoost(${boost.id})">
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
                <a class="page-link" href="javascript:void(0)" onclick="fetchBoosts(${getPageFromUrl(link.url) || currentPage})">
                    ${link.label}
                </a>
            </li>
        `;
            });
            return paginationHtml;
        }

        function fetchBoosts(page = 1) {
            axios.get(`/system/request/boosts/list?page=${page}`)
                .then(response => {
                    const {
                        data,
                        current_page: currentPage,
                        links: paginationLinks
                    } = response.data;

                    boostTableBody.innerHTML = buildBoostTable(data);
                    paginationNav.innerHTML = buildPaginationLinks(paginationLinks, currentPage);
                })
                .catch(error => {
                    console.error('Error fetching boosts:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch boost data.',
                    });
                });
        }

        function deleteBoost(boostId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this request!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then(result => {
                if (result.isConfirmed) {
                    axios.delete(`/system/request/boosts/${boostId}/destroy`)
                        .then(response => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Request boost has been deleted.'
                            });
                            fetchBoosts();
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to delete boost request.'
                            });
                            console.error('Error deleting request boost:', error);
                        });
                }
            });
        }

        fetchBoosts();
    </script>
@endsection
