@extends('layouts.app')

@section('content')

<style>
    table.table tbody tr:hover { background-color: #f2f2f2 !important; cursor: pointer; }
    .modal.show .modal-dialog {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-height: 100vh;
        margin: 0 auto;
    }
    table.table td, table.table th { color:#222; }
    .btn-sm { padding:2px 6px; font-size:.70rem; border-radius:3px; }
</style>

<div id="content">
    <div class="midde_cont">
        <div class="container-fluid">

            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title d-flex align-items-center justify-content-between">
                        <h2>Messages Center</h2>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs mt-3" id="mainMessagesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="proposals-tab" data-bs-toggle="tab"
                        data-bs-target="#proposals" type="button" role="tab" aria-selected="true">
                        <i class="fa fa-file-text-o me-1"></i> Proposals
                    </button>
                </li>
            </ul>

            <div class="tab-content border border-top-0 p-3 bg-white rounded-bottom" id="mainMessagesTabContent">

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
                                        <tr>
                                            <td>{{ $proposal->id }}</td>
                                            <td>{{ $proposal->title }}</td>
                                            <td>{{ $proposal->location ?? 'N/A' }}</td>
                                            <td>{{ $proposal->target_agenda ?? 'N/A' }}</td>
                                            <td>{{ number_format($proposal->approved_budget ?? 0, 2) }}</td>
                                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                                            <td>{{ $proposal->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info viewProposalBtn"
                                                    data-id="{{ $proposal->id }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewProposalModal">
                                                    <i class="fa fa-eye"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- MODAL --}}
                            <div class="modal fade" id="viewProposalModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Proposal Details</h5>
                                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <h5 id="vp_title">Loading...</h5>
                                            <p class="text-muted mb-3">
                                                <strong>Created:</strong> <span id="vp_created"></span>
                                            </p>

                                            {{-- Proponent --}}
                                          <div class="card mb-3">
    <div class="card-body p-2">
        <h6 class="mb-2"><strong>Proponent Information</strong></h6>

        <div class="row">
            <div class="col-md-6">
                <strong>First Name:</strong>
                <p class="mb-1" id="vp_user_first_name"></p>
            </div>
            <div class="col-md-6">
                <strong>Last Name:</strong>
                <p class="mb-1" id="vp_user_last_name"></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <strong>College:</strong>
                <p class="mb-1" id="vp_user_college"></p>
            </div>
            <div class="col-md-6">
                <strong>Phone:</strong>
                <p class="mb-1" id="vp_user_phone"></p>
            </div>
        </div>

        {{-- ✅ NEW ROW --}}
        <div class="row">
            <div class="col-md-6">
                <strong>User Type:</strong>
                <p class="mb-1">
                    <span class="badge bg-info text-dark" id="vp_user_type"></span>
                </p>
            </div>
            <div class="col-md-6">
                <strong>Email:</strong>
                <p class="mb-1" id="vp_user_email"></p>
            </div>
        </div>
    </div>
</div>


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
                                                <div class="col-md-6">
                                                    <strong>Organization:</strong>
                                                    <p id="vp_organization_name" class="mb-0"></p>
                                                    <small class="text-muted">Date Signed: <span id="vp_date_signed"></span></small>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <strong>Description:</strong>
                                                <p id="vp_description"></p>
                                            </div>

                                            <hr>
                                            <h6 class="mb-2"><strong>Attachments</strong></h6>
                                            <div id="vp_files" class="d-flex flex-column gap-2"></div>

                                            <hr>
                                            <h6 class="mb-2"><strong>Flags</strong></h6>
                                            <div id="vp_flags" class="d-flex flex-wrap gap-2"></div>

                                            <hr>
                                            <h6 class="mb-2"><strong>Other Details</strong></h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Code:</strong>
                                                    <div id="vp_code" class="text-muted"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Remarks:</strong>
                                                    <div id="vp_remarks" class="text-muted"></div>
                                                </div>
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

                            {{-- JS --}}
                            <script>
                                function escHtml(s) {
                                    return String(s ?? '')
                                        .replaceAll('&', '&amp;')
                                        .replaceAll('<', '&lt;')
                                        .replaceAll('>', '&gt;')
                                        .replaceAll('"', '&quot;')
                                        .replaceAll("'", '&#039;');
                                }

                                document.querySelectorAll('.viewProposalBtn').forEach(btn => {
                                    btn.addEventListener('click', async function() {
                                        const id = this.dataset.id;
                                        if (!id) return;

                                        // loading state
                                        document.getElementById('vp_title').textContent = 'Loading...';
                                        document.getElementById('vp_files').innerHTML = '<span class="text-muted">Loading attachments…</span>';
                                        document.getElementById('vp_flags').innerHTML = '<span class="text-muted">Loading flags…</span>';

                                        try {
                                            const url = "{{ route('proposals.showJson', ':id') }}".replace(':id', id);
                                            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                                            const json = await res.json();

                                            if (!json.ok) throw new Error('Failed');

                                            const p = json.proposal || {};
                                            const u = json.user || {};

                                            document.getElementById('vp_title').textContent = p.title || 'N/A';
                                            document.getElementById('vp_created').textContent = p.created_at || '';
                                            document.getElementById('vp_location').textContent = p.location || 'N/A';
                                            document.getElementById('vp_target_agenda').textContent = p.target_agenda || 'N/A';
                                            document.getElementById('vp_budget').textContent = Number(p.approved_budget || 0).toLocaleString(undefined, { minimumFractionDigits: 2 });
                                            document.getElementById('vp_description').textContent = p.description || 'No description';

                                            document.getElementById('vp_organization_name').textContent = p.organization_name || '—';
                                            document.getElementById('vp_date_signed').textContent = p.date_signed || '—';

                                           // User / Proponent fields
document.getElementById('vp_user_first_name').textContent = u.first_name || 'N/A';
document.getElementById('vp_user_last_name').textContent  = u.last_name || 'N/A';
document.getElementById('vp_user_college').textContent    = u.college || 'N/A';
document.getElementById('vp_user_phone').textContent      = u.phone || 'N/A';
document.getElementById('vp_user_email').textContent      = u.email || 'N/A';

// ✅ User Type (formatted)
const userTypeRaw = u.user_type || 'unknown';
const userTypeLabel = userTypeRaw
    .replace(/_/g, ' ')
    .replace(/\b\w/g, c => c.toUpperCase());

document.getElementById('vp_user_type').textContent = userTypeLabel;


                                            document.getElementById('vp_code').textContent = p.code || '—';
                                            document.getElementById('vp_remarks').textContent = p.remarks || '—';

                                            // attachments
                                            const files = [];
                                            if (p.documentation_url) files.push({ label: 'Documentation Report', url: p.documentation_url });
                                            if (p.mou_url) files.push({ label: 'MOU File', url: p.mou_url });
                                            if (p.moa_url) files.push({ label: 'MOA File', url: p.moa_url });
                                            if (p.drive_link) files.push({ label: 'Drive Link', url: p.drive_link });
                                            if (p.moa_link) files.push({ label: 'MOA Link', url: p.moa_link });

                                            const vpFiles = document.getElementById('vp_files');
                                            if (!files.length) {
                                                vpFiles.innerHTML = '<span class="text-muted">No attachments.</span>';
                                            } else {
                                                vpFiles.innerHTML = files.map(f => `
                                                    <a class="btn btn-sm btn-outline-primary text-start"
                                                       href="${escHtml(f.url)}" target="_blank" rel="noopener">
                                                       📎 ${escHtml(f.label)}
                                                    </a>
                                                `).join('');
                                            }

                                            // flags
                                            const flagsMap = {
                                                in_house: 'In-House',
                                                revised_proposal: 'Revised Proposal',
                                                ntp: 'NTP',
                                                endorsement: 'Endorsement',
                                                proposal_presentation: 'Proposal Presentation',
                                                proposal_documents: 'Proposal Documents',
                                                program_proposal: 'Program Proposal',
                                                project_proposal: 'Project Proposal',
                                                moa_mou: 'MOA/MOU',
                                                activity_design: 'Activity Design',
                                                certificate_of_appearance: 'Certificate of Appearance',
                                                attendance_sheet: 'Attendance Sheet',
                                                photos: 'Photos',
                                                terminal_report: 'Terminal Report',
                                            };

                                            const vpFlags = document.getElementById('vp_flags');
                                            const trueFlags = Object.keys(flagsMap).filter(k => !!p[k]);
                                            vpFlags.innerHTML = trueFlags.length
                                                ? trueFlags.map(k => `<span class="badge bg-success">${escHtml(flagsMap[k])}</span>`).join(' ')
                                                : `<span class="text-muted">No flags marked.</span>`;

                                            // set approve id
                                            document.getElementById('approveProposalBtn').dataset.id = id;

                                        } catch (e) {
                                            document.getElementById('vp_title').textContent = 'Error loading proposal';
                                            document.getElementById('vp_files').innerHTML = '<span class="text-danger">Failed to load attachments.</span>';
                                            document.getElementById('vp_flags').innerHTML = '<span class="text-danger">Failed to load flags.</span>';
                                        }
                                    });
                                });

                                // approve handler (keep your existing logic)
                                document.getElementById('approveProposalBtn').addEventListener('click', function() {
                                    const id = this.dataset.id;
                                    if (!id) return;

                                    Swal.fire({
                                        title: "Approve this proposal?",
                                        text: "This action cannot be undone.",
                                        icon: "question",
                                        showCancelButton: true,
                                        confirmButtonText: "Yes, approve",
                                        cancelButtonText: "Cancel",
                                        confirmButtonColor: "#28a745",
                                        cancelButtonColor: "#6c757d"
                                    }).then((result) => {
                                        if (!result.isConfirmed) return;

                                        const approveBtn = document.getElementById('approveProposalBtn');
                                        approveBtn.disabled = true;
                                        approveBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Approving...`;

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
                                        .then(() => {
                                            Swal.fire({
                                                title: "Approved!",
                                                text: "The proposal has been approved successfully.",
                                                icon: "success",
                                                confirmButtonColor: "#28a745"
                                            }).then(() => window.location.reload());
                                        })
                                        .catch(() => {
                                            Swal.fire({
                                                title: "Error!",
                                                text: "Failed to approve proposal.",
                                                icon: "error",
                                                confirmButtonColor: "#dc3545"
                                            });
                                        })
                                        .finally(() => {
                                            approveBtn.disabled = false;
                                            approveBtn.innerHTML = `<i class="fa fa-check"></i> Approve`;
                                        });
                                    });
                                });
                            </script>
                        </div>
                    @else
                        <div class="alert alert-info mt-3">No pending proposals found.</div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
