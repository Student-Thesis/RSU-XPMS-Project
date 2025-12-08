<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Proposal;

class AgreementController extends Controller
{
    public function register()
    {
        $registeredUserId = session('registered_user_id');
        $proposalId = session('proposal_id'); // if you also passed this

        return view('agreements.register', compact('registeredUserId', 'proposalId'));
    }

    // (Optional) list all
    public function index()
    {
        $agreements = Agreement::latest()->paginate(12);

        return view('agreements.index', compact('agreements'));
    }

    // (Optional) show form
    public function create()
    {
        return view('agreements.create');
    }

    public function store(Request $request)
    {
        try {
            Log::info('AgreementController@store called', [
                'input' => $request->except(['mouFile', 'moaFile']),
            ]);

            $data = $request->validate([
                'organization_name' => ['nullable', 'string', 'max:255'],
                'date_signed' => ['nullable', 'date'],
                'mouFile' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
                'moaFile' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
                'mou_link' => ['nullable', 'string', 'max:2048'],
                'moa_link' => ['nullable', 'string', 'max:2048'],
                'user_id' => ['nullable', 'string'],
                'proposal_id' => ['nullable', 'string'],
            ]);

            // Resolve user_id as early as possible
            $userId = auth()->id() ?: $data['user_id'] ?? null ?: session('registered_user_id');

            // Resolve proposal_id from request or session
            $proposalId = $data['proposal_id'] ?? session('proposal_id');

            Log::info('Agreement resolved IDs', [
                'user_id' => $userId,
                'proposal_id' => $proposalId,
            ]);

            if (!$userId) {
                return back()->withInput()->with('error', 'User information is missing. Please register or login again.');
            }

            $user = User::find($userId);

            // Check if user submitted *any* agreement data
            $hasAnyData = !empty($data['organization_name']) || !empty($data['date_signed']) || !empty($data['mou_link']) || !empty($data['moa_link']) || $request->hasFile('mouFile') || $request->hasFile('moaFile');

            Log::info('Agreement hasAnyData check', [
                'hasAnyData' => $hasAnyData,
            ]);

            // ==================================
            // CASE 1: NO AGREEMENT DATA PROVIDED
            // ==================================
            if (!$hasAnyData) {
                Log::info('Agreement: no data provided, skipping Agreement::create but still sending account email', [
                    'user_id' => $userId,
                    'proposal_id' => $proposalId,
                ]);

                try {
                    $adminEmail = 'nelmardapulang@gmail.com';

                    // --- Admin notification (optional) ---
                    if ($user) {
                        $adminBody = "A new user account has been registered (no agreement data submitted).\n\n" . "User: {$user->first_name} {$user->last_name} ({$user->email})\n" . "User ID: {$userId}\n" . "Proposal ID: {$proposalId}\n" . "Status: Waiting for admin review and approval of the proposal.\n";

                        Mail::raw($adminBody, function ($message) use ($adminEmail) {
                            $message->to($adminEmail)->subject('New User Registered - Approval Pending');
                        });

                        Log::info('Admin account-created email sent (no agreement data)', [
                            'to' => $adminEmail,
                            'user_id' => $userId,
                            'proposal_id' => $proposalId,
                        ]);
                    }

                    // --- User welcome email ---
                    if ($user && $user->email) {
                        $userBody = "Dear {$user->first_name},\n\n" . "Your account has been registered in the system successfully.\n\n" . "Please wait for the admin to check your proposal and approve your account.\n\n" . "Thank you for your patience.\n\n" . "Best regards,\n";

                        Mail::raw($userBody, function ($message) use ($user) {
                            $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Your Account Has Been Registered');
                        });

                        Log::info('User account-created email sent (no agreement data)', [
                            'to' => $user->email,
                            'user_id' => $userId,
                        ]);
                    } else {
                        Log::warning('User account-created email not sent: user missing or no email', [
                            'user_id' => $userId,
                        ]);
                    }
                } catch (\Throwable $mailEx) {
                    Log::warning('Account-created email(s) failed to send (no agreement data)', [
                        'error' => $mailEx->getMessage(),
                        'user_id' => $userId,
                        'proposal_id' => $proposalId,
                    ]);
                }

                return redirect()->route('notifications.agreement')->with('success', 'Your account has been created. You may submit agreement documents later.');
            }

            // ==================================
            // CASE 2: AGREEMENT DATA PROVIDED
            // ==================================

            // Build payload for Agreement
            $payload = [
                'user_id' => $userId,
                'proposal_id' => $proposalId,
            ];

            if (!empty($data['organization_name'])) {
                $payload['organization_name'] = $data['organization_name'];
            }

            if (!empty($data['date_signed'])) {
                $payload['date_signed'] = $data['date_signed'];
            }

            if (!empty($data['mou_link'])) {
                $payload['mou_link'] = $data['mou_link'];
            }

            if (!empty($data['moa_link'])) {
                $payload['moa_link'] = $data['moa_link'];
            }

            if ($request->hasFile('mouFile')) {
                $payload['mou_path'] = $request->file('mouFile')->storeAs('agreements', self::uniqueName($request->file('mouFile')), 'public');
            }

            if ($request->hasFile('moaFile')) {
                $payload['moa_path'] = $request->file('moaFile')->storeAs('agreements', self::uniqueName($request->file('moaFile')), 'public');
            }

            unset($data['user_id'], $data['proposal_id']);

            // ✅ Create OR update Agreement for this proposal
            $agreement = Agreement::updateOrCreate(['proposal_id' => $proposalId], $payload);

            Log::info('Agreement stored/updated', [
                'agreement_id' => $agreement->id,
                'user_id' => $userId,
                'proposal_id' => $proposalId,
            ]);

            // ✅ ALSO UPDATE THE RELATED PROPOSAL
            if ($proposalId) {
                $proposal = Proposal::find($proposalId);

                if ($proposal) {
                    // Build update array for proposals table
                    $proposalUpdate = [
                        'moa_mou' => 1,
                    ];

                    // Mirror fields from agreement → proposals table
                    if (!empty($agreement->organization_name)) {
                        $proposalUpdate['organization_name'] = $agreement->organization_name;
                    }

                    if (!empty($agreement->date_signed)) {
                        $proposalUpdate['date_signed'] = $agreement->date_signed;
                    }

                    if (!empty($agreement->mou_path)) {
                        $proposalUpdate['mou_path'] = $agreement->mou_path;
                    }

                    if (!empty($agreement->mou_link)) {
                        $proposalUpdate['mou_link'] = $agreement->mou_link;
                    }

                    if (!empty($agreement->moa_path)) {
                        $proposalUpdate['moa_path'] = $agreement->moa_path;
                    }

                    if (!empty($agreement->moa_link)) {
                        $proposalUpdate['moa_link'] = $agreement->moa_link;
                    }

                    // Optionally mirror best link into drive_link
                    if (!empty($agreement->moa_link)) {
                        $proposalUpdate['drive_link'] = $agreement->moa_link;
                    } elseif (!empty($agreement->mou_link) && empty($proposal->drive_link)) {
                        $proposalUpdate['drive_link'] = $agreement->mou_link;
                    }

                    $proposal->update($proposalUpdate);

                    Log::info('Proposal updated from Agreement', [
                        'proposal_id' => $proposalId,
                        'proposal_update' => $proposalUpdate,
                    ]);
                } else {
                    Log::warning('Proposal not found when trying to update from Agreement', [
                        'proposal_id' => $proposalId,
                    ]);
                }
            }

            $this->logActivity('Created/Updated Agreement', [
                'agreement' => $agreement->toArray(),
                'proposal_id' => $proposalId,
            ]);

            // ================
            // ✉️ Send Emails
            // ================
            try {
                Log::info('Agreement email block entered', [
                    'user_id' => $userId,
                    'agreement_id' => $agreement->id,
                    'proposal_id' => $proposalId,
                ]);

                $adminEmail = 'nelmardapulang@gmail.com';

                $orgName = $agreement->organization_name ?? 'N/A';
                $dateSigned = $agreement->date_signed ?? 'N/A';
                $mouLink = $agreement->mou_link ?? 'N/A';
                $moaLink = $agreement->moa_link ?? 'N/A';
                $userLine = $user ? "{$user->first_name} {$user->last_name} ({$user->email})" : 'Unknown User';

                // Admin email
                $adminBody = "A new agreement has been submitted.\n\n" . "User: {$userLine}\n" . "User ID: {$userId}\n" . "Proposal ID: {$proposalId}\n" . "Organization: {$orgName}\n" . "Date Signed: {$dateSigned}\n" . "MOU Link: {$mouLink}\n" . "Proposal Link: {$moaLink}\n";

                Mail::raw($adminBody, function ($message) use ($adminEmail) {
                    $message->to($adminEmail)->subject('New Agreement Submitted');
                });

                Log::info('Admin agreement email sent (Mail::raw executed)', [
                    'to' => $adminEmail,
                    'user_id' => $userId,
                    'proposal_id' => $proposalId,
                ]);

                // User email
                if ($user && $user->email) {
                    $userBody = "Dear {$user->first_name},\n\n" . "Thank you for submitting your agreement documents.\n\n" . "Proposal ID: {$proposalId}\n" . "Organization: {$orgName}\n" . "Date Signed: {$dateSigned}\n" . "MOU Link: {$mouLink}\n" . "Proposal Link: {$moaLink}\n\n" . "Our admin team will review your submission and contact you if anything else is needed.\n\n" . "Best regards,\n";

                    Mail::raw($userBody, function ($message) use ($user) {
                        $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Your Agreement Submission Has Been Received');
                    });

                    Log::info('User agreement email sent (Mail::raw executed)', [
                        'to' => $user->email,
                        'user_id' => $userId,
                        'proposal_id' => $proposalId,
                    ]);
                } else {
                    Log::warning('User email not sent: user missing or no email', [
                        'user_id' => $userId,
                        'proposal_id' => $proposalId,
                    ]);
                }
            } catch (\Throwable $mailEx) {
                Log::warning('Agreement email(s) failed to send', [
                    'error' => $mailEx->getMessage(),
                    'user_id' => $userId,
                    'agreement_id' => $agreement->id ?? null,
                    'proposal_id' => $proposalId,
                ]);
            }

            return redirect()->route('notifications.agreement')->with('success', 'Documents uploaded successfully.');
        } catch (\Throwable $e) {
            Log::error('Agreement upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['mouFile', 'moaFile']),
                'user_id' => auth()->id() ?: session('registered_user_id'),
                'proposal_id' => $request->input('proposal_id') ?? session('proposal_id'),
            ]);

            $this->logActivity('Agreement Upload Failed', [
                'error' => $e->getMessage(),
                'input' => $request->except(['mouFile', 'moaFile']),
                'proposal_id' => $request->input('proposal_id') ?? session('proposal_id'),
            ]);

            return back()->withInput()->with('error', 'Upload failed. Please try again.');
        }
    }

    // Helper to generate collision-safe filenames
    protected static function uniqueName(\Illuminate\Http\UploadedFile $file): string
    {
        $ext = $file->getClientOriginalExtension();
        $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        return Str::slug($base) . '-' . Str::random(8) . '.' . strtolower($ext);
    }

    /**
     * 🧾 Local logging method (same as in CalendarEventController style)
     */
    protected function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id' => Str::uuid(),
            'user_id' => Auth::id(),
            'notifiable_user_id' => Auth::id(),
            'action' => $action,
            'model_type' => Agreement::class,
            'model_id' => $changes['agreement']['id'] ?? null,
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
