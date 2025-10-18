<?php

namespace App\Http\Controllers;

use App\Models\SettingsClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingsClassificationController extends Controller
{
    // Optional: protect with auth middleware
    public function __construct()
    {
        $this->middleware('auth')->except(['listJson']);
    }

    public function index()
    {
        $items = SettingsClassification::orderBy('name')->paginate(10);
        return view('settings_classifications.index', compact('items'));
    }

    public function create()
    {
        return view('settings_classifications.create');
    }

    public function store(Request $request)
{
    try {
        $data = $request->validate([
            // Unique among non-deleted rows:
            'name' => 'required|string|max:100|unique:settings_classifications,name,NULL,id,deleted_at,NULL',
            'is_active' => 'nullable|in:true,false,1,0,on,off',
        ]);

        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active'); // false if unchecked

        \App\Models\SettingsClassification::create($data);

        return redirect()
            ->route('settings_classifications.index')
            ->with('success', 'Classification created.');
    } catch (\Throwable $e) {
        \Log::error('SettingsClassification store failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'input' => $request->all(),
        ]);

        return back()
            ->withInput()
            ->withErrors(['general' => 'Failed to save. ' . $e->getMessage()]);
    }
}

    public function edit(SettingsClassification $settings_classification)
    {
        return view('settings_classifications.edit', [
            'item' => $settings_classification 
        ]);
    }

    public function update(Request $request, \App\Models\SettingsClassification $settings_classification)
{
    try {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:settings_classifications,name,' . $settings_classification->id . ',id,deleted_at,NULL',
            'is_active' => 'nullable|in:true,false,1,0,on,off',
        ]);

        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $settings_classification->update($data);

        return redirect()
            ->route('settings_classifications.index')
            ->with('success', 'Classification updated.');
    } catch (\Throwable $e) {
        \Log::error('SettingsClassification update failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'input' => $request->all(),
            'id' => $settings_classification->id,
        ]);

        return back()
            ->withInput()
            ->withErrors(['general' => 'Failed to update. ' . $e->getMessage()]);
    }
}

    public function destroy(SettingsClassification $settings_classification)
    {
        $settings_classification->delete();

        return redirect()->route('settings_classifications.index')
            ->with('success', 'Classification deleted.');
    }

    // Optional quick toggle endpoint
    public function toggle(SettingsClassification $settings_classification)
    {
        $settings_classification->update(['is_active' => ! $settings_classification->is_active]);

        return back()->with('success', 'Status updated.');
    }

    // Optional: JSON list for AJAX dropdowns
    public function listJson()
    {
        return SettingsClassification::active()
            ->orderBy('name')
            ->get(['id','name','slug']);
    }
}
