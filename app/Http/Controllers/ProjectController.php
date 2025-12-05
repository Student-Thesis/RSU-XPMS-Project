<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\SettingsTargetAgenda;

class ProjectController extends Controller
{
    /**
     * Display all proposals belonging to the logged-in user.
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        $college = $request->input('college');
        $status = $request->input('status');

        // Fetch ACTIVE target agendas
        $targetAgendas = SettingsTargetAgenda::active()->orderBy('name')->get();

        $proposals = Proposal::query()
            ->when(Auth::user()->department_id != 1, function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->when($q, function ($query, $q) {
                $query->where(function ($qq) use ($q) {
                    $qq->whereRaw('BINARY title LIKE ?', ["%{$q}%"])
                        ->orWhereRaw('BINARY team_members LIKE ?', ["%{$q}%"])
                        ->orWhereRaw('BINARY target_agenda LIKE ?', ["%{$q}%"])
                        ->orWhereRaw('BINARY location LIKE ?', ["%{$q}%"])
                        ->orWhereRaw('BINARY partner LIKE ?', ["%{$q}%"]);
                });
            })
            ->when($college && $college !== 'All', fn($query) => $query->where('location', $college))
            ->when($status && $status !== 'All', fn($query) => $query->where('status', $status))
            ->latest()
            ->get();

        return view('projects.index', compact('proposals', 'q', 'college', 'status', 'targetAgendas'));
    }

    /**
     * Inline update (AJAX)
     */
    public function inline(Request $request, Proposal $project)
    {
        $request->validate([
            'column' => 'required|string',
            'value' => 'nullable',
        ]);

        $column = $request->column;
        $value = $request->value;

        $before = $project->getOriginal($column);

        // Update the requested column
        $project->update([$column => $value]);

        // 🔐 log inline update
        $this->logActivity('Inline Updated Project Proposal', [
            'proposal_id' => $project->id,
            'column' => $column,
            'old' => $before,
            'new' => $value,
        ]);

        return response()->json(['success' => true]);
    }

    public function create()
    {
         $targetAgendas = SettingsTargetAgenda::active()->orderBy('name')->get();
        return view('projects.create', compact('targetAgendas'));
    }

    public function store(Request $request)
    {
        // Validate (only 'title' is required; the rest are nullable)
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'classification' => ['nullable', 'string', 'max:100'],
            'leader' => ['nullable', 'string', 'max:255'],
            'team_members' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'target_agenda' => ['nullable', 'string', 'max:255'],

            'in_house' => ['nullable', 'in:0,1'],
            'revised_proposal' => ['nullable', 'in:0,1'],
            'ntp' => ['nullable', 'in:0,1'],
            'endorsement' => ['nullable', 'in:0,1'],
            'proposal_presentation' => ['nullable', 'in:0,1'],
            'proposal_documents' => ['nullable', 'in:0,1'],
            'program_proposal' => ['nullable', 'in:0,1'],
            'project_proposal' => ['nullable', 'in:0,1'],
            'moa_mou' => ['nullable', 'in:0,1'],
            'activity_design' => ['nullable', 'in:0,1'],
            'certificate_of_appearance' => ['nullable', 'in:0,1'],
            'attendance_sheet' => ['nullable', 'in:0,1'],

            'approved_budget' => ['nullable', 'numeric', 'min:0'],
            'expenditure' => ['nullable', 'numeric', 'min:0'],
            'fund_utilization_rate' => ['nullable', 'string', 'max:50'],

            'source_of_funds' => ['nullable', 'string', 'max:255'],
            'partner' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:50'],
            'documentation_report' => ['nullable', 'string'],
            'code' => ['nullable', 'string', 'max:50'],
            'remarks' => ['nullable', 'string'],
            'drive_link' => ['nullable', 'url'],
        ]);

        // Attach creator
        $validated['user_id'] = auth()->id();

        // Normalize boolean flags
        $flagFields = ['in_house', 'revised_proposal', 'ntp', 'endorsement', 'proposal_presentation', 'proposal_documents', 'program_proposal', 'project_proposal', 'moa_mou', 'activity_design', 'certificate_of_appearance', 'attendance_sheet'];
        foreach ($flagFields as $f) {
            if ($request->has($f)) {
                $validated[$f] = $request->boolean($f) ? 1 : 0;
            }
        }

        // sanitize numeric strings
        foreach (['approved_budget', 'expenditure'] as $money) {
            if (isset($validated[$money])) {
                $validated[$money] = (float) str_replace([',', ' '], '', (string) $validated[$money]);
            }
        }

        if (empty($validated['status'])) {
            $validated['status'] = 'Ongoing';
        }

        $proposal = Proposal::create($validated);

        // 🔐 log create
        $this->logActivity('Created Project Proposal', [
            'proposal' => $proposal->toArray(),
        ]);

        return redirect()->route('projects')->with('success', 'Proposal created successfully!');
    }

    /**
     * Edit form
     */
public function edit(Proposal $project)
{
    // Fetch ACTIVE target agendas (same as index)
    $targetAgendas = SettingsTargetAgenda::active()->orderBy('name')->get();

    return view('projects.edit', compact('project', 'targetAgendas'));
}


    /**
     * Update after editing form
     */
   public function update(Request $request, Proposal $project)
{
    $validated = $request->validate([
        'title'                   => ['required', 'string', 'max:255'],
        'classification'          => ['nullable', 'string', 'max:100'],
        'leader'                  => ['nullable', 'string', 'max:255'],
        'team_members'            => ['nullable', 'string'],
        'location'                => ['nullable', 'string', 'max:255'],
        'target_agenda'           => ['nullable', 'string', 'max:255'],

        'in_house'                => ['nullable', 'in:0,1'],
        'revised_proposal'        => ['nullable', 'in:0,1'],
        'ntp'                     => ['nullable', 'in:0,1'],
        'endorsement'             => ['nullable', 'in:0,1'],
        'proposal_presentation'   => ['nullable', 'in:0,1'],
        'proposal_documents'      => ['nullable', 'in:0,1'],
        'program_proposal'        => ['nullable', 'in:0,1'],
        'project_proposal'        => ['nullable', 'in:0,1'],
        'moa_mou'                 => ['nullable', 'in:0,1'],
        'activity_design'         => ['nullable', 'in:0,1'],
        'certificate_of_appearance' => ['nullable', 'in:0,1'],
        'attendance_sheet'        => ['nullable', 'in:0,1'],

        'approved_budget'         => ['nullable', 'numeric', 'min:0'],
        'expenditure'             => ['nullable', 'numeric', 'min:0'],
        'fund_utilization_rate'   => ['nullable', 'string', 'max:50'],

        'source_of_funds'         => ['nullable', 'string', 'max:255'],
        'partner'                 => ['nullable', 'string', 'max:255'],
        'status'                  => ['nullable', 'string', 'max:50'],
        'documentation_report'    => ['nullable', 'string'],
        'code'                    => ['nullable', 'string', 'max:50'],
        'remarks'                 => ['nullable', 'string'],
        'drive_link'              => ['nullable', 'url'],
    ]);

    $before = $project->toArray();

    // Normalize boolean flags (0/1)
    $flagFields = [
        'in_house',
        'revised_proposal',
        'ntp',
        'endorsement',
        'proposal_presentation',
        'proposal_documents',
        'program_proposal',
        'project_proposal',
        'moa_mou',
        'activity_design',
        'certificate_of_appearance',
        'attendance_sheet',
    ];

    foreach ($flagFields as $f) {
        // If present in request, treat "1" as yes, else 0
        if ($request->has($f)) {
            $validated[$f] = $request->input($f) == '1' ? 1 : 0;
        } else {
            // if not in request (e.g. unchecked), default to 0
            $validated[$f] = 0;
        }
    }

    // Sanitize numeric strings
    foreach (['approved_budget', 'expenditure'] as $money) {
        if (isset($validated[$money])) {
            $validated[$money] = (float) str_replace([',', ' '], '', (string) $validated[$money]);
        }
    }

    // Default status if empty
    if (empty($validated['status'])) {
        $validated['status'] = $project->status ?? 'Ongoing';
    }

    $project->update($validated);

    $after = $project->fresh()->toArray();

    // 🔐 log update
    $this->logActivity('Updated Project Proposal', [
        'proposal_id' => $project->id,
        'before'      => $before,
        'after'       => $after,
    ]);

    return redirect()->route('projects')->with('success', 'Project updated successfully!');
}

    /**
     * Delete a proposal
     */
    public function destroy(Proposal $project)
    {
       

        $dump = $project->toArray();
        $project->delete();

        // 🔐 log delete
        $this->logActivity('Deleted Project Proposal', [
            'proposal' => $dump,
        ]);

        // note: your route name here was 'projects.index' in original
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    /**
     * Local logger (no trait)
     */
    protected function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id' => (string) Str::uuid(),
            'user_id' => Auth::id(),
            'notifiable_user_id' => Auth::id(),
            'action' => $action,
            'model_type' => Proposal::class,
            'model_id' => $changes['proposal']['id'] ?? ($changes['proposal_id'] ?? null),
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
