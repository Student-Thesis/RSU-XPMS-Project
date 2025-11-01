@extends('layouts.app')

@section('content')
<div id="content">
    @include('layouts.partials.topnav')

    <div class="midde_cont">
        <div class="container-fluid">
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title d-flex align-items-center justify-content-between gap-2 flex-wrap">
                        <h3 class="m-0">Project Proposals</h3>

                        <button type="button"
                                class="btn btn-success btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#addProposalModal">
                            <i class="fa fa-plus"></i> Add Proposal
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filters + Search -->
            <form method="GET" action="{{ route('projects') }}" class="row align-items-end g-3 mb-3">
                <div class="col-md-3">
                    <label><strong>Search:</strong></label>
                    <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Search anything...">
                </div>

                <div class="col-md-3">
                    <label><strong>Filter by College/Campus:</strong></label>
                    <select name="college" class="form-control">
                        <option value="All" {{ ($college ?? '') === 'All' ? 'selected' : '' }}>All</option>
                        @foreach (['CAS','CBA','CET','CAFES','CCMADI','CED','GEPS','CALATRAVA CAMPUS','STA. MARIA CAMPUS','SANTA FE CAMPUS','SAN ANDRES CAMPUS','SAN AGUSTIN CAMPUS','ROMBLON CAMPUS','CAJIDIOCAN CAMPUS','SAN FERNANDO CAMPUS'] as $opt)
                            <option value="{{ $opt }}" {{ ($college ?? '') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label><strong>Filter by Status:</strong></label>
                    <select name="status" class="form-control">
                        <option value="All" {{ ($status ?? '') === 'All' ? 'selected' : '' }}>All</option>
                        <option value="Ongoing" {{ ($status ?? '') === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="Completed" {{ ($status ?? '') === 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ ($status ?? '') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary w-100" style="margin-top: 26px;">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table id="proposalTable" class="table table-bordered table-striped text-center align-middle">
                    <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Classification</th>
                        <th>Leader</th>
                        <th>Team Members</th>
                        <th>College/Campus</th>
                        <th>Target Agenda</th>
                        <th>In-House</th>
                        <th>Revised</th>
                        <th>NTP</th>
                        <th>Endorsement</th>
                        <th>Presentation</th>
                        <th>Documents</th>
                        <th>Program</th>
                        <th>Project</th>
                        <th>MOA/MOU</th>
                        <th>Activity Design</th>
                        <th>COA</th>
                        <th>Attendance</th>
                        <th>Budget</th>
                        <th>Funds</th>
                        <th>Expenditure</th>
                        <th>Rate</th>
                        <th>Partner</th>
                        <th>Status</th>
                        <th>Documentation</th>
                        <th>Code</th>
                        <th>Remarks</th>
                        <th>Drive Link</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($proposals as $proposal)
                        @php
                            $leader = $proposal->leader ?? '—';
                            $college = $proposal->location ?? '—';
                            $team = $proposal->team_members ?: '—';
                            $agenda = $proposal->target_agenda ?: '—';
                            $budget = number_format($proposal->approved_budget, 2);
                            $code = optional($proposal->created_at)->format('Y') . '-' . str_pad($loop->iteration, 3, '0', STR_PAD_LEFT);
                        @endphp

                        <tr data-id="{{ $proposal->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $proposal->title }}</td>

                            <td>
                                <input list="classifications" class="form-control inline-edit" data-col="classification"
                                       value="{{ $proposal->classification }}">
                                <datalist id="classifications">
                                    <option value="Program"><option value="Project">
                                </datalist>
                            </td>

                            <td>{{ $leader }}</td>
                            <td>{{ $team }}</td>
                            <td>{{ $college }}</td>
                            <td>{{ $agenda }}</td>

                            @foreach (['in_house','revised_proposal','ntp','endorsement','proposal_presentation','proposal_documents','program_proposal','project_proposal','moa_mou','activity_design','certificate_of_appearance','attendance_sheet'] as $field)
                                <td>
                                    <select class="dropdown-yesno {{ $proposal->$field ? 'yes' : 'no' }}"
                                            data-col="{{ $field }}" onchange="updateDropdownColor(this)">
                                        <option {{ !$proposal->$field ? 'selected' : '' }}>No</option>
                                        <option {{ $proposal->$field ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </td>
                            @endforeach

                            <td>{{ $budget }}</td>
                            <td contenteditable="true" class="inline-cell" data-col="source_of_funds">{{ $proposal->source_of_funds ?? '—' }}</td>
                            <td contenteditable="true" class="inline-cell" data-col="expenditure">{{ $proposal->expenditure ?? '—' }}</td>
                            <td contenteditable="true" class="inline-cell" data-col="fund_utilization_rate">{{ $proposal->fund_utilization_rate ?? '—' }}</td>
                            <td>{{ $proposal->partner ?? '—' }}</td>

                            <td>
                                <select class="form-control inline-select" data-col="status">
                                    @foreach(['Ongoing','Completed','Cancelled'] as $st)
                                        <option value="{{ $st }}" {{ $proposal->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td contenteditable="true" class="inline-cell" data-col="documentation_report">{{ $proposal->documentation_report ?? '—' }}</td>
                            <td contenteditable="true" class="inline-cell" data-col="code">{{ $proposal->code ?? $code }}</td>
                            <td contenteditable="true" class="inline-cell" data-col="remarks">{{ $proposal->remarks ?? '—' }}</td>
                            <td contenteditable="true" class="inline-cell" data-col="drive_link">{{ $proposal->drive_link ?? '—' }}</td>

                            <td>
                                <a href="{{ route('projects.edit', $proposal->id) }}" class="btn btn-warning btn-xs p-1 me-1"><i class="fa fa-edit"></i></a>
                                <button type="button" class="btn btn-danger btn-xs p-1 btn-delete" data-id="{{ $proposal->id }}" data-action="{{ route('projects.destroy', $proposal->id) }}"><i class="fa fa-trash"></i></button>
                                <form id="delete-form-{{ $proposal->id }}" action="{{ route('projects.destroy', $proposal->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="30" class="text-muted">No proposals found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.table td{padding:4px 6px!important;vertical-align:middle!important}
.dropdown-yesno.yes{background:#e7f7ef;color:#1f7a4a}
.dropdown-yesno.no{background:#fdecea;color:#b42318}
</style>

<script>
const CSRF_TOKEN=document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function updateDropdownColor(el){el.classList.remove('yes','no');el.classList.add(el.value.toLowerCase()==='yes'?'yes':'no');}
document.addEventListener('click',async e=>{
 const btn=e.target.closest('.btn-delete');if(!btn)return;
 const id=btn.dataset.id;const form=document.getElementById(`delete-form-${id}`);
 const ok=await Swal.fire({title:'Delete proposal?',text:'This action cannot be undone.',icon:'warning',showCancelButton:true,confirmButtonText:'Yes, delete it'}).then(r=>r.isConfirmed);
 if(ok)form.submit();
});
</script>

<!-- Add Proposal Modal -->
<div class="modal fade" id="addProposalModal" tabindex="-1" aria-labelledby="addProposalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xxl modal-dialog-scrollable custom-modal-90">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h5 class="modal-title"><i class="fa fa-plus-circle me-1"></i> Add New Proposal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" action="{{ route('projects.store') }}">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Classification <span class="text-danger">*</span></label>
              <select name="classification" class="form-control" required>
                <option value="Program">Program</option><option value="Project">Project</option>
              </select>
            </div>
            <div class="col-md-6"><label class="form-label">Leader</label><input name="leader" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Team Members</label><input name="team_members" class="form-control"></div>
            <div class="col-md-6">
              <label class="form-label">College/Campus</label>
              <select name="location" class="form-control">
                <option value="">—</option>
                @foreach (['CAS','CBA','CET','CAFES','CCMADI','CED','GEPS','CALATRAVA CAMPUS','STA. MARIA CAMPUS','SANTA FE CAMPUS','SAN ANDRES CAMPUS','SAN AGUSTIN CAMPUS','ROMBLON CAMPUS','CAJIDIOCAN CAMPUS','SAN FERNANDO CAMPUS'] as $opt)
                  <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6"><label class="form-label">Target Agenda</label><input name="target_agenda" class="form-control"></div>
            @php
              $yesNo=['in_house'=>'In-House','revised_proposal'=>'Revised Proposal','ntp'=>'NTP','endorsement'=>'Endorsement','proposal_presentation'=>'Proposal Presentation','proposal_documents'=>'Proposal Documents','program_proposal'=>'Program Proposal','project_proposal'=>'Project Proposal','moa_mou'=>'MOA/MOU','activity_design'=>'Activity Design','certificate_of_appearance'=>'Certificate of Appearance','attendance_sheet'=>'Attendance Sheet'];
            @endphp
            @foreach($yesNo as $n=>$l)
              <div class="col-6 col-md-4">
                <label class="form-label">{{ $l }}</label>
                <select name="{{ $n }}" class="form-control"><option value="0">No</option><option value="1">Yes</option></select>
              </div>
            @endforeach
            <div class="col-md-4"><label class="form-label">Approved Budget</label><input type="number" step="0.01" name="approved_budget" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Expenditure</label><input type="number" step="0.01" name="expenditure" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Fund Utilization Rate</label><input name="fund_utilization_rate" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Source of Funds</label><input name="source_of_funds" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Partner</label><input name="partner" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Status</label>
              <select name="status" class="form-control"><option>Ongoing</option><option>Completed</option><option>Cancelled</option></select>
            </div>
            <div class="col-md-4"><label class="form-label">Code</label><input name="code" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Drive Link</label><input name="drive_link" class="form-control"></div>
            <div class="col-md-12"><label class="form-label">Documentation Report</label><input name="documentation_report" class="form-control"></div>
            <div class="col-md-12"><label class="form-label">Remarks</label><textarea name="remarks" class="form-control" rows="2"></textarea></div>
          </div>
        </div>
        <div class="modal-footer py-2">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
