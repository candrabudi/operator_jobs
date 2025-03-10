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
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPlatformModal">Add
                            Platform</button>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>ID</th>
                                <th>Social Media Name</th>
                                <th>Description</th>
                                <th>Engagement</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="topic-table-body">

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
                    <form id="addPlatformForm">
                        @csrf
                        <div class="mb-3">
                            <label for="social_media_name" class="form-label">Social Media Name</label>
                            <input type="text" class="form-control" id="social_media_name" name="social_media_name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="engagement_types" class="form-label">Engagement Types</label>
                            @foreach ($engagements as $eggm)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="engagement_type_{{ $eggm->id }}"
                                        value="{{ $eggm->id }}" />
                                    <label class="form-check-label"
                                        for="engagement_type_{{ $eggm->id }}">{{ $eggm->engagement_type }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Social Media</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Social Media Platform Modal -->
    <div class="modal fade" id="editEngagementModal" tabindex="-1" aria-labelledby="editEngagementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEngagementModalLabel">Edit Social Media Platform</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editEngagementForm">
                        @csrf
                        <input type="hidden" id="edit_engagement_id">
                        <div class="mb-3">
                            <label for="edit_social_media_name" class="form-label">Social Media Name</label>
                            <input type="text" class="form-control" id="edit_social_media_name"
                                name="social_media_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="edit_description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_engagement_types" class="form-label">Engagement Types</label>
                            @foreach ($engagements as $eggm)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                        id="edit_engagement_type_{{ $eggm->id }}" value="{{ $eggm->id }}" />
                                    <label class="form-check-label"
                                        for="edit_engagement_type_{{ $eggm->id }}">{{ $eggm->engagement_type }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Social Media</button>
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
        function fetchSocialMediaPlatforms() {
            axios.get('{{ route('system.social_media_platforms.list') }}')
                .then(response => {
                    const platforms = response.data;
                    let html = '';

                    platforms.forEach(platform => {
                        const createdAt = new Date(platform.created_at).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        const updatedAt = new Date(platform.updated_at).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        let engagementsHtml = '';
                        platform.social_media_platform_engagement.forEach(engagement => {
                            engagementsHtml += `
                        <tr>
                            <td>${engagement.engagement_type}</td>
                            <td>${engagement.min}</td>
                            <td>${engagement.max}</td>
                            <td>${new Date(engagement.created_at).toLocaleDateString('id-ID')}</td>
                            <td>${new Date(engagement.updated_at).toLocaleDateString('id-ID')}</td>
                        </tr>`;
                        });
                        html += `
                    <tr>
                        <td>${platform.id}</td>
                        <td>${platform.social_media_name}</td>
                        <td>${platform.description}</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="toggleEngagement(${platform.id})">
                                Show Engagement
                            </button>
                        </td>
                        <td>${createdAt}</td>
                        <td>${updatedAt}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" 
                                data-id="${platform.id}" 
                                data-name="${platform.social_media_name}" 
                                data-description="${platform.description}" 
                                data-engagement='${JSON.stringify(platform.social_media_platform_engagement)}'
                                onclick="handleEditPlatform(this)">
                                    Edit
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deletePlatform(${platform.id})">Delete</button>
                        </td>
                    </tr>
                    <tr id="engagement-row-${platform.id}" class="d-none">
                        <td colspan="7">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Engagement Type</th>
                                        <th>Min</th>
                                        <th>Max</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${engagementsHtml}
                                </tbody>
                            </table>
                        </td>
                    </tr>`;
                    });

                    document.getElementById('topic-table-body').innerHTML = html;
                })
                .catch(error => console.error('Error fetching social media platforms:', error));
        }

        function toggleEngagement(id) {
            const engagementRow = document.getElementById(`engagement-row-${id}`);
            if (engagementRow.classList.contains('d-none')) {
                engagementRow.classList.remove('d-none');
                engagementRow.previousElementSibling.querySelector('button').textContent = 'Hide Engagement';
            } else {
                engagementRow.classList.add('d-none');
                engagementRow.previousElementSibling.querySelector('button').textContent = 'Show Engagement';
            }
        }

        document.getElementById('addPlatformForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const socialMediaName = document.getElementById('social_media_name').value;
            const description = document.getElementById('description').value;

            const engagementTypes = Array.from(document.querySelectorAll('input[type="checkbox"]:checked')).map(
                cb => cb.value);

            axios.post('{{ route('system.social_media_platforms.store') }}', {
                social_media_name: socialMediaName,
                description: description,
                engagement_types: engagementTypes
            }).then(response => {
                Swal.fire('Success', response.data.message, 'success');
                document.getElementById('addPlatformForm').reset();
                fetchSocialMediaPlatforms();
                $('#addPlatformModal').modal('hide');
            }).catch(error => {
                console.error('Error adding engagement:', error);
                Swal.fire('Error', 'Failed to add engagement', 'error');
            });
        });

        function handleEditPlatform(button) {
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const description = button.getAttribute('data-description');
            const engagementString = button.getAttribute('data-engagement');

            let engagements = [];
            try {
                engagements = JSON.parse(engagementString);
            } catch (error) {
                console.error("Error parsing engagements JSON:", error);
            }
            editPlatform(id, name, description, engagements);
        }

        function editPlatform(id, name, description, engagements) {
            document.getElementById('edit_engagement_id').value = id;
            document.getElementById('edit_social_media_name').value = name;
            document.getElementById('edit_description').value = description;

            document.querySelectorAll('#editEngagementForm .form-check-input').forEach(checkbox => {
                checkbox.checked = false;
            });

            engagements.forEach(engagement => {
                const engagementCheckbox = document.querySelector(
                    `#edit_engagement_type_${engagement.engagement_type_id}`);
                if (engagementCheckbox) {
                    engagementCheckbox.checked = true;
                }
            });

            const editModal = new bootstrap.Modal(document.getElementById('editEngagementModal'));
            editModal.show();
        }

        document.getElementById('editEngagementForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('edit_engagement_id').value;
            const socialMediaName = document.getElementById('edit_social_media_name').value;
            const description = document.getElementById('edit_description').value;
            const engagementTypes = Array.from(document.querySelectorAll('input[type="checkbox"]:checked')).map(
                cb => cb.value);

            axios.put(`/system/social-media-platforms/${id}/update`, {
                social_media_name: socialMediaName,
                description: description,
                engagement_types: engagementTypes
            }).then(response => {
                Swal.fire('Success', response.data.message, 'success');
                fetchSocialMediaPlatforms();
                $('#editEngagementModal').modal('hide');
            }).catch(error => {
                console.error('Error updating platform:', error);
                Swal.fire('Error', 'Failed to update platform', 'error');
            });
        });

        function deletePlatform(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this platform!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/system/social_media_platforms/${id}/destroy`)
                        .then(response => {
                            Swal.fire('Deleted!', response.data.message, 'success');
                            fetchSocialMediaPlatforms();
                        })
                        .catch(error => {
                            console.error('Error deleting platform:', error);
                            Swal.fire('Error', 'Failed to delete platform', 'error');
                        });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchSocialMediaPlatforms();
        });
    </script>
@endpush
