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
}
