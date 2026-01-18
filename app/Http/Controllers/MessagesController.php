<?php

// app/Http/Controllers/MessagesController.php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\PublicMessage;
use App\Models\PrivateMessage;
use App\Models\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        // Pending proposals (from your previous requirement)
        $pendingProposals = Proposal::with('user')->where('status', 'pending')->get();  

        // Public messages (everyone can see)
        $publicMessages = PublicMessage::with('user') 
            ->latest()
            ->take(100)
            ->get();

        // Private messages only involving the logged-in user
        $privateMessages = PrivateMessage::with(['sender', 'recipient'])
            ->where(function ($q) {
                $q->where('sender_id', auth()->id())
                  ->orWhere('recipient_id', auth()->id());
            })
            ->latest()
            ->take(100)
            ->get();

        // List of users to send private messages to
        $users = User::where('id', '!=', auth()->id())
            ->orderBy('first_name') // or first_name / last_name depending on your schema
            ->get();

        return view('messages.index', compact(
            'pendingProposals',
            'publicMessages',
            'privateMessages',
            'users'
        ));
    }

    public function storePublic(Request $request)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        PublicMessage::create([
            'user_id' => auth()->id(),
            'body'    => $validated['body'],
        ]);

        return back()->with('success', 'Public message posted.');
    }

    public function storePrivate(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => ['required', 'exists:users,id', 'different:sender_id'],
            'body'         => ['required', 'string', 'max:5000'],
        ]);

        PrivateMessage::create([
            'sender_id'    => auth()->id(),
            'recipient_id' => $validated['recipient_id'],
            'body'         => $validated['body'],
        ]);

        return back()->with('success', 'Private message sent.');
    }

    public function showJson(Proposal $proposal)
{
    $proposal->load('user');

    // if you're serving from subfolder
    $basePath = request()->ip() === '127.0.0.1' ? '' : '/public';

    $makeUrl = function ($path) use ($basePath) {
        if (!$path) return null;

        $p = ltrim((string) $path, '/');

        // normalize if path accidentally contains "public/"
        if (str_starts_with($p, 'public/')) {
            $p = substr($p, 7);
        }

        return $basePath . '/' . $p;
    };

    return response()->json([
        'ok' => true,
        'proposal' => [
            'id' => $proposal->id,
            'title' => $proposal->title,
            'classification' => $proposal->classification,
            'location' => $proposal->location,
            'target_agenda' => $proposal->target_agenda,
            'approved_budget' => $proposal->approved_budget,
            'status' => $proposal->status,
            'description' => $proposal->description,
            'remarks' => $proposal->remarks,
            'code' => $proposal->code,
            'created_at' => optional($proposal->created_at)->format('M d, Y h:i A'),

            // Agreement / org info
            'organization_name' => $proposal->organization_name,
            'date_signed' => $proposal->date_signed ? \Carbon\Carbon::parse($proposal->date_signed)->format('M d, Y') : null,

            // Links
            'drive_link' => $proposal->drive_link,
            'moa_link' => $proposal->moa_link,

            // stored paths
            'mou_path' => $proposal->mou_path,
            'moa_path' => $proposal->moa_path,
            'documentation_report' => $proposal->documentation_report,

            // generated URLs (ready for <a href>)
            'mou_url' => $makeUrl($proposal->mou_path),
            'moa_url' => $makeUrl($proposal->moa_path),
            'documentation_url' => $makeUrl($proposal->documentation_report),

            // flags
            'in_house' => (bool) $proposal->in_house,
            'revised_proposal' => (bool) $proposal->revised_proposal,
            'ntp' => (bool) $proposal->ntp,
            'endorsement' => (bool) $proposal->endorsement,
            'proposal_presentation' => (bool) $proposal->proposal_presentation,
            'proposal_documents' => (bool) $proposal->proposal_documents,
            'program_proposal' => (bool) $proposal->program_proposal,
            'project_proposal' => (bool) $proposal->project_proposal,
            'moa_mou' => (bool) $proposal->moa_mou,
            'activity_design' => (bool) $proposal->activity_design,
            'certificate_of_appearance' => (bool) $proposal->certificate_of_appearance,
            'attendance_sheet' => (bool) $proposal->attendance_sheet,
            'photos' => (bool) $proposal->photos,
            'terminal_report' => (bool) $proposal->terminal_report,
        ],
          'user' => [
        'first_name' => optional($proposal->user)->first_name,
        'last_name'  => optional($proposal->user)->last_name,
        'college'    => optional($proposal->user)->college,
        'phone'      => optional($proposal->user)->phone,
        'email'      => optional($proposal->user)->email,
        'user_type'  => optional($proposal->user)->user_type, // ✅ ADD THIS
    ],
    ]);
}
}
