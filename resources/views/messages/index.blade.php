@extends('layouts.app')

@section('content')

{{-- ============================ --}}
{{-- CUSTOM STYLES --}}
{{-- ============================ --}}
<style>
    /* Light gray hover on table rows */
    table.table tbody tr:hover {
        background-color: #f2f2f2 !important;
        cursor: pointer;
    }

    /* Force modal to appear center-center */
    .modal.show .modal-dialog {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-height: 100vh;
        margin: 0 auto;
    }
</style>

<div id="content">
    @include('layouts.partials.topnav')

    <div class="midde_cont">
        <div class="container-fluid">

            {{-- ============================ --}}
            {{-- Page Header --}}
            {{-- ============================ --}}
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title d-flex align-items-center justify-content-between">
                        <h2>Messages Center</h2>
                    </div>
                </div>
            </div>

            {{-- ============================ --}}
            {{-- Main Tabs --}}
            {{-- ============================ --}}
            <ul class="nav nav-tabs mt-3" id="mainMessagesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="proposals-tab" data-bs-toggle="tab"
                        data-bs-target="#proposals" type="button" role="tab" aria-selected="true">
                        <i class="fa fa-file-text-o me-1"></i> Proposals
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="messages-tab" data-bs-toggle="tab"
                        data-bs-target="#messages" type="button" role="tab" aria-selected="false">
                        <i class="fa fa-envelope-o me-1"></i> Messages
                    </button>
                </li>
            </ul>

            <div class="tab-content border border-top-0 p-3 bg-white rounded-bottom" id="mainMessagesTabContent">

                {{-- ============================ --}}
                {{-- PROPOSALS TAB --}}
                {{-- ============================ --}}
                <div class="tab-pane fade show active" id="proposals" role="tabpanel">

                    @if ($pendingProposals->count() > 0)
                        <div class="table-responsive">

                            <table class="table table-bordered table-hover align-middle">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Location</th>
                                        <th>Target Agenda</th>
                                        <th>Approved Budget</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendingProposals as $proposal)
                                        <tr data-proposal-id="{{ $proposal->id }}">
                                            <td>{{ $proposal->id }}</td>
                                            <td>{{ $proposal->title }}</td>
                                            <td>{{ $proposal->location ?? 'N/A' }}</td>
                                            <td>{{ $proposal->target_agenda ?? 'N/A' }}</td>
                                            <td>{{ number_format($proposal->approved_budget ?? 0, 2) }}</td>
                                            <td>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            </td>
                                            <td>{{ $proposal->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info viewProposalBtn"
                                                    data-id="{{ $proposal->id }}"
                                                    data-title="{{ $proposal->title }}"
                                                    data-location="{{ $proposal->location }}"
                                                    data-target_agenda="{{ $proposal->target_agenda }}"
                                                    data-budget="{{ $proposal->approved_budget }}"
                                                    data-description="{{ $proposal->description }}"
                                                    data-created="{{ $proposal->created_at->format('M d, Y h:i A') }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewProposalModal">
                                                    <i class="fa fa-eye"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- ============================ --}}
                            {{-- VIEW PROPOSAL MODAL --}}
                            {{-- ============================ --}}
                            <div class="modal fade" id="viewProposalModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Proposal Details</h5>
                                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <h5 id="vp_title"></h5>
                                            <p class="text-muted mb-3">
                                                <strong>Created:</strong> <span id="vp_created"></span>
                                            </p>

                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <strong>Location:</strong>
                                                    <p id="vp_location"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Target Agenda:</strong>
                                                    <p id="vp_target_agenda"></p>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <strong>Approved Budget:</strong>
                                                    <p>₱ <span id="vp_budget"></span></p>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Description:</strong>
                                                <p id="vp_description"></p>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button class="btn btn-success" id="approveProposalBtn">
                                                <i class="fa fa-check"></i> Approve
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- ============================ --}}
                            {{-- JS HANDLER --}}
                            {{-- ============================ --}}
                            <script>
                                // Fill modal on View button click
                                document.querySelectorAll('.viewProposalBtn').forEach(btn => {
                                    btn.addEventListener('click', function() {
                                        document.getElementById('vp_title').textContent = this.dataset.title;
                                        document.getElementById('vp_location').textContent = this.dataset.location || 'N/A';
                                        document.getElementById('vp_target_agenda').textContent = this.dataset.target_agenda || 'N/A';
                                        document.getElementById('vp_budget').textContent = Number(this.dataset.budget ?? 0).toLocaleString(undefined, {
                                            minimumFractionDigits: 2
                                        });
                                        document.getElementById('vp_description').textContent = this.dataset.description || 'No description';
                                        document.getElementById('vp_created').textContent = this.dataset.created;

                                        document.getElementById('approveProposalBtn').dataset.id = this.dataset.id;
                                    });
                                });

                                // Approve button
                                document.getElementById('approveProposalBtn').addEventListener('click', function() {
                                    const id = this.dataset.id;
                                    if (!id) return;

                                    if (!confirm('Approve this proposal?')) return;

                                    const url = "{{ route('proposals.approve', ':id') }}".replace(':id', id);

                                    fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({})
                                    })
                                    .then(res => res.json())
                                    .then(() => window.location.reload())
                                    .catch(() => alert('Failed to approve proposal.'));
                                });
                            </script>

                        </div>
                    @else
                        <div class="alert alert-info mt-3">No pending proposals found.</div>
                    @endif

                </div>

                {{-- ============================ --}}
                {{-- MESSAGES TAB (NO CHANGES) --}}
                {{-- ============================ --}}
                <div class="tab-pane fade" id="messages" role="tabpanel">
                    {{-- Entire messages section remains unchanged --}}
                    {!! $messagesSection ?? '' !!}
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    table.table td, 
table.table th {
    color: #222; /* darker text */
}
.btn-sm {
    padding: 2px 6px;
    font-size: 0.70rem;
    border-radius: 3px;
}
</style>

@endsection
