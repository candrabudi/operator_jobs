@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Social Media Topics</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Social Media Topics</li>
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
                                placeholder="Search Topics...">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div
                        class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTopicModal">Add
                            Topic</button>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>ID</th>
                                <th>Topic Name</th>
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

    <div class="modal fade" id="addTopicModal" tabindex="-1" aria-labelledby="addTopicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTopicModalLabel">Add Topic</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTopicForm">
                        @csrf
                        <div class="mb-3">
                            <label for="topic_name" class="form-label">Topic Name</label>
                            <input type="text" class="form-control" id="topic_name" name="topic_name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Topic</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editTopicModal" tabindex="-1" aria-labelledby="editTopicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTopicModalLabel">Edit Topic</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTopicForm">
                        @csrf
                        <input type="hidden" id="edit_topic_id">
                        <div class="mb-3">
                            <label for="edit_topic_name" class="form-label">Topic Name</label>
                            <input type="text" class="form-control" id="edit_topic_name" name="topic_name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Topic</button>
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
        function fetchTopics() {
            axios.get('{{ route('system.topics.list') }}')
                .then(response => {
                    const topics = response.data;
                    let html = '';
                    topics.forEach(topic => {
                        const createdAt = new Date(topic.created_at).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        const updatedAt = new Date(topic.updated_at).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });

                        html += `<tr>
                            <td>${topic.id}</td>
                            <td>${topic.topic_name}</td>
                            <td>${createdAt}</td>
                            <td>${updatedAt}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editTopic(${topic.id}, '${topic.topic_name}')">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteTopic(${topic.id})">Delete</button>
                            </td>
                         </tr>`;
                    });
                    document.getElementById('topic-table-body').innerHTML = html;
                })
                .catch(error => console.error('Error fetching topics:', error));
        }


        // Add Topic
        document.getElementById('addTopicForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const topicName = document.getElementById('topic_name').value;

            axios.post('{{ route('system.topics.store') }}', {
                topic_name: topicName
            }).then(response => {
                Swal.fire('Success', response.data.message, 'success');
                document.getElementById('addTopicForm').reset();
                fetchTopics();
                $('#addTopicModal').modal('hide');
            }).catch(error => {
                console.error('Error adding topic:', error);
                Swal.fire('Error', 'Failed to add topic', 'error');
            });
        });

        function editTopic(id, name) {
            document.getElementById('edit_topic_id').value = id;
            document.getElementById('edit_topic_name').value = name;
            $('#editTopicModal').modal('show');
        }

        document.getElementById('editTopicForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('edit_topic_id').value;
            const topicName = document.getElementById('edit_topic_name').value;

            axios.put(`/system/topics/${id}/update`, {
                topic_name: topicName
            }).then(response => {
                Swal.fire('Success', response.data.message, 'success');
                fetchTopics();
                $('#editTopicModal').modal('hide');
            }).catch(error => {
                console.error('Error updating topic:', error);
                Swal.fire('Error', 'Failed to update topic', 'error');
            });
        });

        function deleteTopic(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this topic!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/system/topics/${id}/destroy`)
                        .then(response => {
                            Swal.fire('Deleted!', response.data.message, 'success');
                            fetchTopics();
                        })
                        .catch(error => {
                            console.error('Error deleting topic:', error);
                            Swal.fire('Error', 'Failed to delete topic', 'error');
                        });
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            fetchTopics();
        });
    </script>
@endpush
