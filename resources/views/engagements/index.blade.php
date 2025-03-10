@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Social Media Engagements</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Social Media Engagements</li>
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
                                placeholder="Search Engagements...">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div
                        class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEngagementModal">Add
                            Engagement</button>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>ID</th>
                                <th>Engagement Type</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="engagement-table-body">

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

    <div class="modal fade" id="addEngagementModal" tabindex="-1" aria-labelledby="addEngagementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEngagementModalLabel">Add Engagement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEngagementForm">
                        @csrf
                        <div class="mb-3">
                            <label for="engagement_type" class="form-label">Engagement Type</label>
                            <input type="text" class="form-control" id="engagement_type" name="engagement_type" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Engagement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editEngagementModal" tabindex="-1" aria-labelledby="editEngagementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEngagementModalLabel">Edit Engagement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editEngagementForm">
                        @csrf
                        <input type="hidden" id="edit_engagement_id">
                        <div class="mb-3">
                            <label for="engagement_type" class="form-label">Engagement Type</label>
                            <input type="text" class="form-control" id="engagement_type" name="engagement_type"
                                required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Engagement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function fetchEngagements() {
            axios.get('{{ route('system.engagements.list') }}')
                .then(response => {
                    const engagements = response.data;
                    let html = '';
                    engagements.forEach(engagement => {
                        const createdAt = new Date(engagement.created_at).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        const updatedAt = new Date(engagement.updated_at).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });

                        html += `<tr>
                            <td>${engagement.id}</td>
                            <td>${engagement.engagement_type}</td>
                            <td>${createdAt}</td>
                            <td>${updatedAt}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editEngagement(${engagement.id}, '${engagement.engagement_type}')">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteEngagement(${engagement.id})">Delete</button>
                            </td>
                         </tr>`;
                    });
                    document.getElementById('engagement-table-body').innerHTML = html;
                })
                .catch(error => console.error('Error fetching engagements:', error));
        }

        document.getElementById('addEngagementForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const engagementName = document.getElementById('engagement_type').value;

            axios.post('{{ route('system.engagements.store') }}', {
                engagement_type: engagementName,
            }).then(response => {
                Swal.fire('Success', response.data.message, 'success');
                document.getElementById('addEngagementForm').reset();
                fetchEngagements();
                $('#addEngagementModal').modal('hide');
            }).catch(error => {
                console.error('Error adding engagement:', error);
                Swal.fire('Error', 'Failed to add engagement', 'error');
            });
        });


        function editEngagement(id, name) {
            document.getElementById('edit_engagement_id').value = id;
            document.getElementById('edit_engagement_type').value = name;
            $('#editEngagementModal').modal('show');
        }

        document.getElementById('editEngagementForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('edit_engagement_id').value;
            const engagementName = document.getElementById('edit_engagement_type').value;

            axios.put(`/system/engagements/${id}/update`, {
                engagement_type: engagementName,
            }).then(response => {
                Swal.fire('Success', response.data.message, 'success');
                fetchEngagements();
                $('#editEngagementModal').modal('hide');
            }).catch(error => {
                console.error('Error updating engagement:', error);
                Swal.fire('Error', 'Failed to update engagement', 'error');
            });
        });


        function deleteEngagement(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this engagement!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/system/engagements/${id}/destroy`)
                        .then(response => {
                            Swal.fire('Deleted!', response.data.message, 'success');
                            fetchEngagements();
                        })
                        .catch(error => {
                            console.error('Error deleting engagement:', error);
                            Swal.fire('Error', 'Failed to delete engagement', 'error');
                        });
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            fetchEngagements();
        });
    </script>
@endpush
