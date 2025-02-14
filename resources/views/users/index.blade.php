@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Users</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Users</li>
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
                                placeholder="Search Contacts...">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div
                        class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <div class="action-btn show-btn" style="display: none">
                            <a href="javascript:void(0)"
                                class="delete-multiple bg-danger-subtle btn me-2 text-danger d-flex align-items-center font-medium">
                                <i class="ti ti-trash text-danger me-1 fs-5"></i> Delete All Row
                            </a>
                        </div>
                        <a href="javascript:void(0)" id="btn-add-contact"
                            class="btn btn-sm btn-info d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#addUserModal">
                            <i class="ti ti-users text-white me-1 fs-5"></i> Tambah User
                        </a>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="user-table-body">

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

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addContactForm">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" class="form-control" required>
                                <option value="superadmin">Superadmin</option>
                                <option value="admin">Admin</option>
                                <option value="operator_posting">Operator Posting</option>
                                <option value="operator_boosting">Operator Boosting</option>
                                <option value="operator_both">Operator Both</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editContactForm">
                        <input type="hidden" id="edit_user_id">
                        <div class="mb-3">
                            <label for="edit_full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="edit_full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="edit_username" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="edit_phone_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">Password (Leave blank to keep current
                                password)</label>
                            <input type="password" class="form-control" id="edit_password">
                        </div>
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <select id="edit_role" class="form-control" required>
                                <option value="superadmin">Superadmin</option>
                                <option value="admin">Admin</option>
                                <option value="operator_posting">Operator Posting</option>
                                <option value="operator_boosting">Operator Boosting</option>
                                <option value="operator_both">Operator Both</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select id="edit_status" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        const userTableBody = document.getElementById('user-table-body');
        const paginationNav = document.getElementById('pagination').querySelector('ul');

        function fetchUsers(page = 1) {
            axios.get(`/system/users/list?page=${page}`)
                .then(response => {
                    const {
                        data: users,
                        current_page: currentPage,
                        links: paginationLinks
                    } = response.data;
                    userTableBody.innerHTML = '';
                    paginationNav.innerHTML = '';

                    users.forEach(user => {
                        const row = `
                            <tr class="search-items">
                                <td>${user.full_name}</td>
                                <td>${user.username}</td>
                                <td>${user.phone_number}</td>
                                <td>${user.role}</td>
                                <td>${user.status === 1 ? 'Active' : 'Inactive'}</td>
                                <td>
                                    <div class="action-btn">
                                        <a href="javascript:void(0)" class="text-info edit" onclick="editUser(${user.id})">
                                            <i class="ti ti-pencil fs-5"></i> Edit
                                        </a>
                                        <a href="javascript:void(0)" class="text-dark delete ms-2" onclick="deleteUser(${user.id})">
                                            <i class="ti ti-trash fs-5"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        `;
                        userTableBody.innerHTML += row;
                    });

                    paginationLinks.forEach(link => {
                        paginationNav.innerHTML += `
                            <li class="page-item ${link.active ? 'active' : ''}">
                                <a class="page-link" href="javascript:void(0)" onclick="fetchUsers(${link.url ? link.url.match(/page=(\d+)/)[1] : currentPage})">
                                    ${link.label}
                                </a>
                            </li>
                        `;
                    });
                })
                .catch(error => console.error('Error fetching users:', error));
        }

        function editUser(userId) {
            axios.get(`/system/users/${userId}/edit`)
                .then(response => {
                    const user = response.data;
                    document.getElementById('edit_user_id').value = user.id;
                    document.getElementById('edit_full_name').value = user.full_name;
                    document.getElementById('edit_username').value = user.username;
                    document.getElementById('edit_phone_number').value = user.phone_number;
                    document.getElementById('edit_role').value = user.role;
                    document.getElementById('edit_status').value = user.status;
                    $('#editUserModal').modal('show');
                })
                .catch(error => console.error('Error fetching user data:', error));
        }

        document.getElementById('editContactForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const userId = document.getElementById('edit_user_id').value;
            const fullName = document.getElementById('edit_full_name').value;
            const username = document.getElementById('edit_username').value;
            const phoneNumber = document.getElementById('edit_phone_number').value;
            const role = document.getElementById('edit_role').value;
            const status = document.getElementById('edit_status').value;

            axios.put(`/system/users/${userId}/update`, {
                    full_name: fullName,
                    username: username,
                    phone_number: phoneNumber,
                    role: role,
                    status: status
                })
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'User updated successfully!'
                    });
                    $('#editUserModal').modal('hide');
                    fetchUsers();
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update user. Please try again.'
                    });
                    console.error('Error updating user:', error);
                });
        });


        function deleteUser(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this user!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then(result => {
                if (result.isConfirmed) {
                    axios.delete(`/system/users/${userId}/destroy`)
                        .then(response => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'User has been deleted.'
                            });
                            fetchUsers();
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

        fetchUsers();
        document.getElementById('addContactForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const fullName = document.getElementById('full_name').value;
            const username = document.getElementById('username').value;
            const phoneNumber = document.getElementById('phone_number').value;
            const role = document.getElementById('role').value;

            axios.post('/system/users/store', {
                    full_name: fullName,
                    username: username,
                    phone_number: phoneNumber,
                    role: role,
                    status: 1
                })
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'User added successfully!'
                    });
                    $('#addUserModal').modal('hide');
                    fetchUsers();
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to add user. Please try again.'
                    });
                    console.error('Error adding user:', error);
                });
        });
    </script>
@endsection
