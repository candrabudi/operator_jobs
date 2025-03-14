@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm p-3 border-0 rounded">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <div class="bg-warning-subtle text-warning text-center py-2 rounded-1">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                        <div class="col-9">
                            <div>
                                <h5 class="card-title mb-1">Pending Posting Requests</h5>
                                <p class="text-muted mb-0">{{ count($pendingPostRequests) }} Pending Postings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm p-3 border-0 rounded">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <div class="bg-info-subtle text-info text-center py-2 rounded-1">
                                <i class="fas fa-bullhorn fa-2x"></i>
                            </div>
                        </div>
                        <div class="col-9">
                            <div>
                                <h5 class="card-title mb-1">Pending Boosting Requests</h5>
                                <p class="text-muted mb-0">{{ count($pendingBoostRequests) }} Pending Boosts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold">Pending Requests Posts</h5>
                        <div class="card shadow-none mt-9 mb-0">
                            <div class="table-responsive">
                                <table class="table table-responsive text-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-0">Operator</th>
                                            <th>Title</th>
                                            <th>Platform</th>
                                            <th>Content</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark">
                                        @foreach ($pendingPostRequests as $requestPost)
                                            <tr>
                                                <td class="ps-0 text-truncate">
                                                    <span class="fw-semibold">{{ $requestPost->updatedBy ? $requestPost->updatedBy->full_name : 'Belum Tindak Lanjut' }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold">{{ $requestPost->title }}</span>
                                                </td>
                                                <td>{{ $requestPost->platform->social_media_name }}</td>
                                                <td>{!! Str::limit($requestPost->content, 25) !!}</td>
                                                <td>
                                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                                </td>
                                                <td>{{ $requestPost->created_at->format('d M, Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold">Pending Requests Boosts</h5>
                        <div class="card shadow-none mt-9 mb-0">
                            <div class="table-responsive">
                                <table class="table table-responsive text-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-0">Operator</th>
                                            <th>Social Media</th>
                                            <th>Platform Type</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark">
                                        @foreach ($pendingBoostRequests as $boostRequest)
                                            <tr>
                                                <td class="ps-0 text-truncate">
                                                    <span class="fw-semibold">{{ $boostRequest->updatedBy ? $boostRequest->updatedBy->full_name : 'Belum Tindak Lanjut' }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold">{{ $boostRequest->platform->social_media_name }}</span>
                                                </td>
                                                <td>{{ strtoupper($boostRequest->engagement->engagement_type) }}</td>
                                                <td>
                                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                                </td>
                                                <td>{{ $boostRequest->created_at->format('d M, Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@endsection