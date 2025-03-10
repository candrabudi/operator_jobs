@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Social Media Accounts</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Social Media Accounts</li>
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
                                placeholder="Search Accounts...">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div
                        class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAccountModal">Add
                            Account</button>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>ID</th>
                                <th>Account Username</th>
                                <th>Topics</th>
                                <th>Platforms</th>
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

    <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccountModalLabel">Add Social Media Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAccountForm">
                        @csrf
                        <div class="mb-3">
                            <label for="account_username" class="form-label">Account Username</label>
                            <input type="text" class="form-control" id="account_username" name="account_username"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="account_password" class="form-label">Account Password</label>
                            <input type="password" class="form-control" id="account_password" name="account_password"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="account_email" class="form-label">Account Email</label>
                            <input type="email" class="form-control" id="account_email" name="account_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="account_email_password" class="form-label">Account Email Password</label>
                            <input type="password" class="form-control" id="account_email_password"
                                name="account_email_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="topics" class="form-label">Topics</label>
                            <select id="topics" class="form-control" name="topics[]" multiple>
                                @foreach ($topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->topic_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="platforms" class="form-label">Platforms</label>
                            @foreach ($platforms as $platform)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="platform_{{ $platform->id }}"
                                        name="platforms[]" value="{{ $platform->id }}">
                                    <label class="form-check-label"
                                        for="platform_{{ $platform->id }}">{{ $platform->social_media_name }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAccountModalLabel">Edit Social Media Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAccountForm">
                        @csrf
                        <input type="hidden" id="account_id" name="account_id">

                        <div class="mb-3">
                            <label for="edit_account_username" class="form-label">Account Username</label>
                            <input type="text" class="form-control" id="edit_account_username"
                                name="account_username" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_account_password" class="form-label">Account Password</label>
                            <input type="password" class="form-control" id="edit_account_password"
                                name="account_password">
                        </div>

                        <div class="mb-3">
                            <label for="edit_account_email" class="form-label">Account Email</label>
                            <input type="email" class="form-control" id="edit_account_email" name="account_email"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_account_email_password" class="form-label">Account Email Password</label>
                            <input type="password" class="form-control" id="edit_account_email_password"
                                name="account_email_password">
                        </div>

                        <div class="mb-3">
                            <label for="edit_topics" class="form-label">Topics</label>
                            <select id="edit_topics" class="form-control" name="topics[]" multiple>
                                @foreach ($topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->topic_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_platforms" class="form-label">Platforms</label>
                            @foreach ($platforms as $platform)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                        id="edit_platform_{{ $platform->id }}" name="platforms[]"
                                        value="{{ $platform->id }}">
                                    <label class="form-check-label"
                                        for="edit_platform_{{ $platform->id }}">{{ $platform->social_media_name }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
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
        function fetchSocialMediaAccounts() {
            axios.get('{{ route('system.social_media_accounts.list') }}')
                .then(response => {
                    const accounts = response.data;
                    let html = '';

                    accounts.forEach(account => {
                        const createdAt = new Date(account.created_at).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        const updatedAt = new Date(account.updated_at).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });

                        let platformsHtml = '';
                        account.social_media_account_platform_assign.forEach(platform => {
                            platformsHtml +=
                                `<span class="badge bg-primary me-1">${platform.social_media_name}</span>`;
                        });

                        let topicsHtml = '';
                        account.social_media_account_topic.forEach(topic => {
                            topicsHtml +=
                                `<span class="badge bg-success me-1">${topic.topic_name}</span>`;
                        });

                        html += `
                    <tr>
                        <td>${account.id}</td>
                        <td>${account.account_username}</td>
                        <td>${platformsHtml}</td>
                        <td>${topicsHtml}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" 
                                data-id="${account.id}" 
                                data-username="${account.account_username}" 
                                data-email="${account.account_email}"
                                data-topics='${JSON.stringify(account.social_media_account_topic)}'
                                data-platforms='${JSON.stringify(account.social_media_account_platform_assign)}'
                                onclick="handleEditAccount(this)">
                                Edit
                            </button>

                            <button class="btn btn-sm btn-danger" onclick="deleteAccount(${account.id})">Delete</button>
                        </td>
                    </tr>`;
                    });

                    document.getElementById('topic-table-body').innerHTML = html;
                })
                .catch(error => console.error('Error fetching social media accounts:', error));
        }


        document.getElementById('addAccountForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const accountUsername = document.getElementById('account_username').value;
            const accountPassword = document.getElementById('account_password').value;
            const accountEmail = document.getElementById('account_email').value;
            const accountEmailPassword = document.getElementById('account_email_password').value;

            const topics = Array.from(document.getElementById('topics').selectedOptions).map(option => option
                .value);
            const platforms = Array.from(document.querySelectorAll('input[name="platforms[]"]:checked')).map(
                checkbox => checkbox.value);

            axios.post('{{ route('system.social_media_accounts.store') }}', {
                account_username: accountUsername,
                account_password: accountPassword,
                account_email: accountEmail,
                account_email_password: accountEmailPassword,
                topics: topics,
                platforms: platforms
            }).then(response => {
                Swal.fire('Success', response.data.message, 'success');
                document.getElementById('addAccountForm').reset();
                fetchSocialMediaAccounts();
                $('#addAccountModal').modal('hide');
            }).catch(error => {
                console.error('Error adding account:', error);
                Swal.fire('Error', 'Failed to add account', 'error');
            });
        });


        function handleEditAccount(button) {
            const id = button.getAttribute('data-id');
            const username = button.getAttribute('data-username');
            const email = button.getAttribute('data-email');
            const topicsString = button.getAttribute('data-topics');
            const platformsString = button.getAttribute('data-platforms');

            let topics = [];
            let platforms = [];

            try {
                topics = JSON.parse(topicsString);
                platforms = JSON.parse(platformsString);
            } catch (error) {
                console.error("Error parsing JSON:", error);
            }

            editAccount(id, username, email, topics, platforms);
        }

        function editAccount(id, username, email, topics, platforms) {
            document.getElementById('account_id').value = id;
            document.getElementById('edit_account_username').value = username;
            document.getElementById('edit_account_email').value = email;

            // Reset Topics selection
            document.querySelectorAll('#editAccountForm select#edit_topics option').forEach(option => {
                option.selected = false;
            });

            // Set selected topics
            topics.forEach(topic => {
                const topicOption = document.querySelector(
                    `#editAccountForm select#edit_topics option[value="${topic.id}"]`);
                if (topicOption) {
                    topicOption.selected = true;
                }
            });

            // Reset Platforms checkboxes
            document.querySelectorAll('#editAccountForm .form-check-input').forEach(checkbox => {
                checkbox.checked = false;
            });

            // Set selected platforms
            platforms.forEach(platform => {
                const platformCheckbox = document.querySelector(`#editAccountForm #edit_platform_${platform.id}`);
                if (platformCheckbox) {
                    platformCheckbox.checked = true;
                }
            });

            const editModal = new bootstrap.Modal(document.getElementById('editAccountModal'));
            editModal.show();
        }

        document.getElementById('editAccountForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const id = document.getElementById('account_id').value;
            const username = document.getElementById('edit_account_username').value;
            const email = document.getElementById('edit_account_email').value;

            // Get selected topics
            const selectedTopics = Array.from(document.querySelectorAll(
                '#editAccountForm select#edit_topics option:checked')).map(
                option => option.value
            );

            // Get selected platforms
            const selectedPlatforms = Array.from(document.querySelectorAll(
                '#editAccountForm input[type="checkbox"]:checked')).map(
                checkbox => checkbox.value
            );

            axios.put(`/system/social-media-accounts/${id}/update`, {
                account_username: username,
                account_email: email,
                topics: selectedTopics,
                platforms: selectedPlatforms
            }).then(response => {
                Swal.fire('Success', response.data.message, 'success');
                fetchSocialMediaAccounts();
                $('#editAccountModal').modal('hide');
            }).catch(error => {
                console.error('Error updating account:', error);
                Swal.fire('Error', 'Failed to update account', 'error');
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
                            fetchSocialMediaAccounts();
                        })
                        .catch(error => {
                            console.error('Error deleting platform:', error);
                            Swal.fire('Error', 'Failed to delete platform', 'error');
                        });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchSocialMediaAccounts();
        });
    </script>
@endpush
