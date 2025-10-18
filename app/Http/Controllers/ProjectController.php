<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;

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

        $proposals = Proposal::query()
            ->where('user_id', Auth::id()) // show only current user's data
            ->when($q, function ($query, $q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('title', 'like', "%{$q}%")
                        ->orWhere('team_members', 'like', "%{$q}%")
                        ->orWhere('target_agenda', 'like', "%{$q}%")
                        ->orWhere('location', 'like', "%{$q}%")
                        ->orWhere('partner', 'like', "%{$q}%");
                });
            })
            ->when($college && $college !== 'All', fn($query) => $query->where('location', $college))
            ->when($status && $status !== 'All', fn($query) => $query->where('status', $status))
            ->latest()
            ->get();

        return view('projects.index', compact('proposals', 'q', 'college', 'status'));
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

        // Ensure user owns the record
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $column = $request->column;
        $value = $request->value;

        // Update the requested column
        $project->update([$column => $value]);

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'classification' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'team_members' => 'nullable|string',
            'target_agenda' => 'nullable|string|max:255',
            'approved_budget' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:50',
        ]);

        $validated['user_id'] = auth()->id();

        Proposal::create($validated);

        return redirect()->route('projects')->with('success', 'Proposal created successfully!');
    }

    /**
     * Edit form
     */
    public function edit(Proposal $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        return view('projects.edit', compact('project'));
    }

    /**
     * Update after editing form
     */
    public function update(Request $request, Proposal $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'classification' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'target_agenda' => 'nullable|string|max:255',
            'approved_budget' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:50',
        ]);

        $project->update($validated);

        return redirect()->route('projects')->with('success', 'Project updated successfully!');
    }

    /**
     * Delete a proposal
     */
    public function destroy(Proposal $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
