<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\SettingsClassification;
use App\Models\SettingsTargetAgenda;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProposalController extends Controller
{
    public function register()
    {
        $classifications = SettingsClassification::active()->orderBy('name')->get();
        $targetAgendas   = SettingsTargetAgenda::active()->orderBy('name')->get();

        return view('proposals.register', compact('classifications', 'targetAgendas'));
    }

    public function index()
    {
        $proposals = Proposal::latest()->paginate(12);

        return view('proposals.list', compact('proposals'));
    }

    /**
     * Show the form for creating a new proposal.
     */
    public function create()
    {
        $classifications = ['Project', 'Program'];
        return view('proposals.create', compact('classifications'));
    }

    /**
     * Store a newly created proposal in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title'                  => 'required|string|max:255',
                'classification'         => 'required|in:Project,Program',
                'team_members'           => 'nullable|string|max:2000',
                'target_agenda'          => 'nullable|string|max:255',
                'location'               => 'nullable|string|max:255',
                'time_frame'             => 'nullable|string|max:255',
                'beneficiaries_who'      => 'nullable|string|max:255',
                'beneficiaries_how_many' => 'nullable|integer|min:0',
                'budget_ps'              => 'nullable|string|max:50',
                'budget_mooe'            => 'nullable|string|max:50',
                'budget_co'              => 'nullable|string|max:50',
                'partner'                => 'nullable|string|max:255',
            ]);

            // Normalize numbers: remove commas/spaces → float
            foreach (['budget_ps','budget_mooe','budget_co'] as $k) {
                if (isset($data[$k]) && $data[$k] !== '') {
                    $clean     = preg_replace('/[,\s]/', '', $data[$k]);
                    $data[$k]  = is_numeric($clean) ? (float) $clean : null;
                } else {
                    $data[$k] = null;
                }
            }

            // Normalize team members
            if (!empty($data['team_members'])) {
                $parts = array_filter(array_map('trim', explode(',', $data['team_members'])));
                $data['team_members'] = implode(', ', $parts);
            }

            $data['user_id'] = auth()->id();

            $proposal = Proposal::create($data);

            // ✅ log success
            $this->logActivity('Created Proposal', [
                'proposal' => $proposal->toArray(),
            ]);

            return redirect()
                ->route('agreement.register')
                ->with('success', 'Proposal submitted successfully! Proceed to agreement.');
        } catch (\Throwable $e) {
            \Log::error('Proposal submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            // ❗ log failure too (optional)
            $this->logActivity('Proposal Submission Failed', [
                'error' => $e->getMessage(),
                'input' => $request->except([]),
            ]);

            return back()->withInput()
                ->with('error', 'Something went wrong while submitting your proposal. Please try again.');
        }
    }

    /**
     * Display the specified proposal.
     */
    public function show(Proposal $proposal)
    {
        return view('proposals.show', compact('proposal'));
    }

    /**
     * Show the form for editing the specified proposal.
     */
    public function edit(Proposal $proposal)
    {
        $classifications = ['Project', 'Program'];
        return view('proposals.edit', compact('proposal', 'classifications'));
    }

    /**
     * Update the specified proposal in storage.
     */
    public function update(Request $request, Proposal $proposal)
    {
        $data = $this->validatedData($request);

        if (!empty($data['team_members'])) {
            $data['team_members'] = $this->normalizeTeamMembers($data['team_members']);
        }

        $before = $proposal->toArray();
        $proposal->update($data);
        $after  = $proposal->fresh()->toArray();

        // ✅ log update
        $this->logActivity('Updated Proposal', [
            'proposal_id' => $proposal->id,
            'before'      => $before,
            'after'       => $after,
        ]);

        return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully.');
    }

    /**
     * Remove the specified proposal from storage.
     */
    public function destroy(Proposal $proposal)
    {
        $dump = $proposal->toArray();
        $proposal->delete();

        // ✅ log delete
        $this->logActivity('Deleted Proposal', [
            'proposal' => $dump,
        ]);

        return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully.');
    }

    /**
     * Centralized validation rules.
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title'                  => ['required', 'string', 'max:255'],
            'classification'         => ['required', Rule::in(['Project', 'Program'])],
            'team_members'           => ['nullable', 'string', 'max:2000'],
            'target_agenda'          => ['nullable', 'string', 'max:255'],
            'location'               => ['nullable', 'string', 'max:255'],
            'time_frame'             => ['nullable', 'string', 'max:255'],
            'beneficiaries_who'      => ['nullable', 'string', 'max:255'],
            'beneficiaries_how_many' => ['nullable', 'integer', 'min:0'],
            'budget_ps'              => ['nullable', 'numeric', 'min:0'],
            'budget_mooe'            => ['nullable', 'numeric', 'min:0'],
            'budget_co'              => ['nullable', 'numeric', 'min:0'],
            'partner'                => ['nullable', 'string', 'max:255'],
        ]);
    }

    /**
     * Normalize comma-separated team member names.
     */
    protected function normalizeTeamMembers(string $input): string
    {
        $parts = array_filter(array_map('trim', explode(',', $input)));
        return implode(', ', $parts);
    }

    /**
     * Local logger (no trait)
     */
    protected function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id'          => (string) Str::uuid(),
            'user_id'     => Auth::id(),
            'action'      => $action,
            'model_type'  => Proposal::class,
            'model_id'    => $changes['proposal']['id']
                             ?? $changes['proposal_id']
                             ?? null,
            'changes'     => $changes,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
