<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\SettingsTargetAgenda;
use Illuminate\Http\UploadedFile; // ⬅️ add this

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
            ->with('agreement') // ✅ EAGER LOAD AGREEMENT
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
    public function inlineUpdate(Request $request, Proposal $project)
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
        // Validate all fields including agreement-related ones
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'classification' => ['nullable', 'string', 'max:100'],
            'leader' => ['nullable', 'string', 'max:255'],
            'team_members' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'target_agenda' => ['nullable', 'string', 'max:255'],

            // Agreement / organization info saved on proposals table
            'organization_name' => ['nullable', 'string', 'max:255'],
            'date_signed' => ['nullable', 'date'],

            // Files (not DB columns; we convert them to *_path)
            'mouFile' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
            'moaFile' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],

            // Links
            // ✅ mou_link removed, replaced by drive_link
            'moa_link' => ['nullable', 'string', 'max:2048'],
            'drive_link' => ['nullable', 'url', 'max:2048'],

            // YES/NO flags
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

            // Numbers
            'approved_budget' => ['nullable', 'numeric', 'min:0'],
            'expenditure' => ['nullable', 'numeric', 'min:0'],
            'fund_utilization_rate' => ['nullable', 'string', 'max:50'],

            // Other info
            'source_of_funds' => ['nullable', 'string', 'max:255'],
            'partner' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:50'],
            'documentation_report' => ['nullable', 'string'],
            'code' => ['nullable', 'string', 'max:50'],
            'remarks' => ['nullable', 'string'],
        ]);

        // Attach creator
        $validated['user_id'] = auth()->id();

        // 1) Normalize YES/NO flags to 0/1
        $flagFields = ['in_house', 'revised_proposal', 'ntp', 'endorsement', 'proposal_presentation', 'proposal_documents', 'program_proposal', 'project_proposal', 'moa_mou', 'activity_design', 'certificate_of_appearance', 'attendance_sheet'];

        foreach ($flagFields as $f) {
            $validated[$f] = $request->input($f) == '1' ? 1 : 0;
        }

        // 2) Sanitize numeric strings (if user types "1,000.00")
        foreach (['approved_budget', 'expenditure'] as $money) {
            if (isset($validated[$money])) {
                $validated[$money] = (float) str_replace([',', ' '], '', (string) $validated[$money]);
            }
        }

        // 3) Handle file uploads → store paths on proposals table
        //    Direct to public/uploads/agreements (no Laravel storage disk)
        if ($request->hasFile('mouFile')) {
            $validated['mou_path'] = $this->moveToPublic($request->file('mouFile'), 'uploads/agreements');
        }

        if ($request->hasFile('moaFile')) {
            $validated['moa_path'] = $this->moveToPublic($request->file('moaFile'), 'uploads/agreements');
        }

        // 4) Auto-set MOA/MOU flag if any agreement data present
        // ✅ replaced mou_link with drive_link
        $hasMoaMouData = !empty($validated['organization_name']) || !empty($validated['date_signed']) || !empty($validated['drive_link']) || !empty($validated['moa_link']) || !empty($validated['mou_path'] ?? null) || !empty($validated['moa_path'] ?? null);

        if ($hasMoaMouData) {
            $validated['moa_mou'] = 1;
        }

        // 5) If no status given, default to "Ongoing"
        if (empty($validated['status'])) {
            $validated['status'] = 'Ongoing';
        }

        // 6) OPTIONAL: if drive_link is empty but moa_link exists, set drive_link = moa_link
        // (keep this only if you want that behavior)
        if (empty($validated['drive_link']) && !empty($validated['moa_link'])) {
            $validated['drive_link'] = $validated['moa_link'];
        }

        // Create Proposal record
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
            'title' => ['required', 'string', 'max:255'],
            'classification' => ['nullable', 'string', 'max:100'],
            'leader' => ['nullable', 'string', 'max:255'],
            'team_members' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'target_agenda' => ['nullable', 'string', 'max:255'],

            // Agreement / organization info
            'organization_name' => ['nullable', 'string', 'max:255'],
            'date_signed' => ['nullable', 'date'],

            // FILES (same idea as store)
            'mouFile' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
            'moaFile' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],

            // LINKS
            // ✅ mou_link removed, replaced by drive_link
            'moa_link' => ['nullable', 'string', 'max:2048'],
            'drive_link' => ['nullable', 'url', 'max:2048'],

            // YES/NO flags
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

            // Numbers
            'approved_budget' => ['nullable', 'numeric', 'min:0'],
            'expenditure' => ['nullable', 'numeric', 'min:0'],
            'fund_utilization_rate' => ['nullable', 'string', 'max:50'],

            // Other info
            'source_of_funds' => ['nullable', 'string', 'max:255'],
            'partner' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:50'],
            'documentation_report' => ['nullable', 'string'],
            'code' => ['nullable', 'string', 'max:50'],
            'remarks' => ['nullable', 'string'],
        ]);

        $before = $project->toArray();

        // ✅ Normalize boolean flags (0/1)
        $flagFields = ['in_house', 'revised_proposal', 'ntp', 'endorsement', 'proposal_presentation', 'proposal_documents', 'program_proposal', 'project_proposal', 'moa_mou', 'activity_design', 'certificate_of_appearance', 'attendance_sheet'];

        foreach ($flagFields as $f) {
            $validated[$f] = $request->input($f) == '1' ? 1 : 0;
        }

        // ✅ Sanitize numeric strings ("1,000.00" → 1000.00)
        foreach (['approved_budget', 'expenditure'] as $money) {
            if (isset($validated[$money])) {
                $validated[$money] = (float) str_replace([',', ' '], '', (string) $validated[$money]);
            }
        }

        // ✅ Handle MOU file upload on edit
        if ($request->hasFile('mouFile')) {
            $validated['mou_path'] = $this->moveToPublic($request->file('mouFile'), 'uploads/agreements');
        }

        // ✅ Handle MOA file upload on edit
        if ($request->hasFile('moaFile')) {
            $validated['moa_path'] = $this->moveToPublic($request->file('moaFile'), 'uploads/agreements');
        }

        // ✅ Auto-set MOA/MOU flag if any agreement data present
        // ✅ replaced mou_link with drive_link
        $hasMoaMouData = !empty($validated['organization_name'] ?? $project->organization_name) || !empty($validated['date_signed'] ?? $project->date_signed) || !empty($validated['drive_link'] ?? $project->drive_link) || !empty($validated['moa_link'] ?? $project->moa_link) || !empty($validated['mou_path'] ?? $project->mou_path) || !empty($validated['moa_path'] ?? $project->moa_path);

        if ($hasMoaMouData) {
            $validated['moa_mou'] = 1;
        }

        // ✅ Default status if empty → keep old or Ongoing
        if (empty($validated['status'])) {
            $validated['status'] = $project->status ?? 'Ongoing';
        }

        // ✅ If drive_link empty but moa_link exists, mirror it (same trick as store)
        if (empty($validated['drive_link']) && !empty($validated['moa_link'] ?? $project->moa_link)) {
            $validated['drive_link'] = $validated['moa_link'] ?? $project->moa_link;
        }

        // ✅ Finally update the record
        $project->update($validated);

        $after = $project->fresh()->toArray();

        // 🔐 log update
        $this->logActivity('Updated Project Proposal', [
            'proposal_id' => $project->id,
            'before' => $before,
            'after' => $after,
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
     * Generate collision-safe filenames
     */
    protected function uniqueName(UploadedFile $file): string
    {
        $ext = $file->getClientOriginalExtension();
        $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        return Str::slug($base) . '-' . Str::random(8) . '.' . strtolower($ext);
    }

    /**
     * ✅ Move uploaded file directly into public/…
     * Returns a web path like: uploads/agreements/abc.pdf
     */
    protected function moveToPublic(UploadedFile $file, string $folder = 'uploads/agreements'): string
    {
        $filename = $this->uniqueName($file);
        $destination = public_path($folder);

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $filename);

        // Path relative to /public so you can use asset($path)
        return trim($folder . '/' . $filename, '/');
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
