<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\User;
use App\Models\SettingsClassification;
use App\Models\SettingsTargetAgenda;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;

class ProposalController extends Controller
{
    public function register()
    {
        // Load from your settings tables
        $classifications = SettingsClassification::active()->orderBy('name')->get();

        $targetAgendas = SettingsTargetAgenda::active()->orderBy('name')->get();

        // Get user id from session (set by RegisterController after successful registration)
        $registeredUserId = session('registered_user_id');

        return view('proposals.register', compact('classifications', 'targetAgendas', 'registeredUserId'));
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
                'title' => 'required|string|max:255',
                'classification' => 'required|in:Project,Program',
                'team_members' => 'nullable|string|max:2000',
                'target_agenda' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'time_frame' => 'nullable|string|max:255',
                'beneficiaries_who' => 'nullable|string|max:255',
                'beneficiaries_how_many' => 'nullable|integer|min:0',
                'budget_ps' => 'nullable|string|max:50',
                'budget_mooe' => 'nullable|string|max:50',
                'budget_co' => 'nullable|string|max:50',
                'partner' => 'nullable|string|max:255',

                // this comes from the hidden field on the create page
                'registered_user_id' => 'nullable|string', // if UUID, keep string
            ]);

            // Get the user_id source:
            // 1) If someone is logged in, use auth()->id()
            // 2) Else, use the registered_user_id passed from registration → proposal
            $userId = auth()->id() ?: $data['registered_user_id'] ?? null;

            if (!$userId) {
                // No user context at all — bail cleanly
                return back()->withInput()->with('error', 'User information is missing. Please register or login again.');
            }

            // Normalize numbers: remove commas/spaces → float
            foreach (['budget_ps', 'budget_mooe', 'budget_co'] as $k) {
                if (isset($data[$k]) && $data[$k] !== '') {
                    $clean = preg_replace('/[,\s]/', '', $data[$k]);
                    $data[$k] = is_numeric($clean) ? (float) $clean : null;
                } else {
                    $data[$k] = null;
                }
            }

            // Normalize team members
            if (!empty($data['team_members'])) {
                $parts = array_filter(array_map('trim', explode(',', $data['team_members'])));
                $data['team_members'] = implode(', ', $parts);
            }

            // Set user_id on proposal (this is what you asked)
            $data['user_id'] = $userId;
            $data['status'] = 'Pending';

            // We don't need this in the Proposal model itself
            unset($data['registered_user_id']);

            $proposal = Proposal::create($data);

            // ✅ log success
            $this->logActivity('Created Proposal', [
                'proposal' => $proposal->toArray(),
            ]);

            // 👉 Pass user_id (and proposal_id if you want) to the next stage
            return redirect()
                ->route('agreement.register')
                ->with([
                    'success' => 'Proposal submitted successfully! Proceed to agreement.',
                    'registered_user_id' => $userId,
                    'proposal_id' => $proposal->id, // optional but usually useful
                ]);
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

            return back()->withInput()->with('error', 'Something went wrong while submitting your proposal. Please try again.');
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
        $after = $proposal->fresh()->toArray();

        // ✅ log update
        $this->logActivity('Updated Proposal', [
            'proposal_id' => $proposal->id,
            'before' => $before,
            'after' => $after,
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
        $parts = array_filter(array_map('trim', explode(',', $input)));
        return implode(', ', $parts);
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

    public function approve(Request $request, $id)
    {
        // Must be logged in
        $user = Auth::user();
        if (!$user) {
            return response()->json(
                [
                    'message' => 'Unauthenticated.',
                ],
                401,
            );
        }

        // OPTIONAL: Only department_id = 1 can approve
        if ($user->department_id != 1) {
            return response()->json(
                [
                    'message' => 'You are not allowed to approve proposals.',
                ],
                403,
            );
        }

        // Find proposal
        $proposal = Proposal::findOrFail($id);

        // Check if already approved
        if ($proposal->status === 'Approved') {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'This proposal is already approved.',
                ],
                422,
            );
        }

        // Update fields
        $proposal->status = 'Approved';

        if ($proposal->isFillable('approved_by')) {
            $proposal->approved_by = $user->id;
        }
        if ($proposal->isFillable('approved_at')) {
            $proposal->approved_at = now();
        }

        $proposal->save();

        // ==============================================
        // Update the status of the user
        // ==============================================
        $userToUpdate = User::find($proposal->user_id);

        if ($userToUpdate) {
            $userToUpdate->status = 'Approved';
            $userToUpdate->save();
        }

        // ==================================================
        // 📧 Send Email Notification to the Proposal Owner
        // ==================================================
        try {
            $proposalOwner = $proposal->user; // must have relationship: Proposal belongsTo User

            if ($proposalOwner && $proposalOwner->email) {
                Mail::raw("Hi {$proposalOwner->first_name},\n\n" . "Your proposal titled '{$proposal->title}' has been approved.\n\n" . "You may now proceed with the next steps.\n\n" . 'Thank you.', function ($message) use ($proposalOwner, $proposal) {
                    $message->to($proposalOwner->email, $proposalOwner->first_name . ' ' . $proposalOwner->last_name)->subject('Your Proposal Has Been Approved');
                });
            }
        } catch (\Throwable $mailError) {
            \Log::warning('Failed to send approval email', [
                'proposal_id' => $proposal->id,
                'user_id' => $proposal->user_id,
                'email' => $proposal->user->email ?? null,
                'error' => $mailError->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Proposal approved successfully.',
        ]);
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(
                [
                    'ok' => false,
                    'message' => 'Unauthenticated.',
                ],
                401,
            );
        }

        if ($user->department_id != 1) {
            return response()->json(
                [
                    'ok' => false,
                    'message' => 'You are not allowed to reject proposals.',
                ],
                403,
            );
        }

        $proposal = Proposal::findOrFail($id);

        // ✅ ALREADY REJECTED (NOT AN ERROR)
        if ($proposal->status === 'Rejected') {
            return response()->json(
                [
                    'ok' => true,
                    'already' => true,
                    'message' => 'This proposal was already rejected.',
                ],
                200,
            );
        }

        // ❌ BLOCK APPROVED
        if ($proposal->status === 'Approved') {
            return response()->json(
                [
                    'ok' => false,
                    'message' => 'Approved proposals cannot be rejected.',
                ],
                422,
            );
        }

        $proposal->status = 'Rejected';

        if ($proposal->isFillable('rejected_by')) {
            $proposal->rejected_by = $user->id;
        }
        if ($proposal->isFillable('rejected_at')) {
            $proposal->rejected_at = now();
        }

        $proposal->save();

        return response()->json([
            'ok' => true,
            'message' => 'Proposal rejected successfully.',
        ]);
    }
}
