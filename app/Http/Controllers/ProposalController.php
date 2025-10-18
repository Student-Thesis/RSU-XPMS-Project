<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SettingsClassification;
use App\Models\SettingsTargetAgenda;

class ProposalController extends Controller
{
    public function register()
    {
        $classifications = SettingsClassification::active()->orderBy('name')->get();
         $targetAgendas = SettingsTargetAgenda::active()->orderBy('name')->get();
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
                $clean = preg_replace('/[,\s]/', '', $data[$k]);
                $data[$k] = is_numeric($clean) ? (float) $clean : null;
            } else {
                $data[$k] = null;
            }
        }

        // Optional: normalize team members commas/spaces
        if (!empty($data['team_members'])) {
            $parts = array_filter(array_map('trim', explode(',', $data['team_members'])));
            $data['team_members'] = implode(', ', $parts);
        }

        $data['user_id'] = auth()->id();

        Proposal::create($data);

        return redirect()->route('agreement.register')
            ->with('success', 'Proposal submitted successfully! Proceed to agreement.');
    } catch (\Throwable $e) {
        \Log::error('Proposal submission failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'input' => $request->all(),
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

        $proposal->update($data);

        return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully.');
    }

    /**
     * Remove the specified proposal from storage.
     */
    public function destroy(Proposal $proposal)
    {
        $proposal->delete();

        return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully.');
    }

    /**
     * Centralized validation rules.
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'classification' => ['required', Rule::in(['Project', 'Program'])],
            'team_members' => ['nullable', 'string', 'max:2000'],
            'target_agenda' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'time_frame' => ['nullable', 'string', 'max:255'],
            'beneficiaries_who' => ['nullable', 'string', 'max:255'],
            'beneficiaries_how_many' => ['nullable', 'integer', 'min:0'],
            'budget_ps' => ['nullable', 'numeric', 'min:0'],
            'budget_mooe' => ['nullable', 'numeric', 'min:0'],
            'budget_co' => ['nullable', 'numeric', 'min:0'],
            'partner' => ['nullable', 'string', 'max:255'],
        ]);
    }

    /**
     * Normalize comma-separated team member names.
     */
    protected function normalizeTeamMembers(string $input): string
    {
        // Split by comma, trim each, remove empties, then join
        $parts = array_filter(array_map('trim', explode(',', $input)));
        return implode(', ', $parts);
    }
}
