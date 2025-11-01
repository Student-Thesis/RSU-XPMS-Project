<?php

namespace App\Http\Controllers;

use App\Models\SettingsClassification;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
                'name'      => 'required|string|max:100|unique:settings_classifications,name,NULL,id,deleted_at,NULL',
                'is_active' => 'nullable|in:true,false,1,0,on,off',
            ]);

            $data['slug']      = Str::slug($data['name']);
            $data['is_active'] = $request->boolean('is_active');

            $item = SettingsClassification::create($data);

            // ✅ log create
            $this->logActivity('Created Settings Classification', [
                'classification' => $item->toArray(),
            ]);

            return redirect()
                ->route('settings_classifications.index')
                ->with('success', 'Classification created.');
        } catch (\Throwable $e) {
            \Log::error('SettingsClassification store failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            // optional: log failure too
            $this->logActivity('Settings Classification Create Failed', [
                'error' => $e->getMessage(),
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

    public function update(Request $request, SettingsClassification $settings_classification)
    {
        try {
            $data = $request->validate([
                'name'      => 'required|string|max:100|unique:settings_classifications,name,' . $settings_classification->id . ',id,deleted_at,NULL',
                'is_active' => 'nullable|in:true,false,1,0,on,off',
            ]);

            $data['slug']      = Str::slug($data['name']);
            $data['is_active'] = $request->boolean('is_active');

            $before = $settings_classification->toArray();
            $settings_classification->update($data);
            $after = $settings_classification->fresh()->toArray();

            // ✅ log update
            $this->logActivity('Updated Settings Classification', [
                'classification_id' => $settings_classification->id,
                'before'            => $before,
                'after'             => $after,
            ]);

            return redirect()
                ->route('settings_classifications.index')
                ->with('success', 'Classification updated.');
        } catch (\Throwable $e) {
            \Log::error('SettingsClassification update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
                'id'    => $settings_classification->id,
            ]);

            // optional: log failure too
            $this->logActivity('Settings Classification Update Failed', [
                'classification_id' => $settings_classification->id,
                'error'             => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['general' => 'Failed to update. ' . $e->getMessage()]);
        }
    }

    public function destroy(SettingsClassification $settings_classification)
    {
        $dump = $settings_classification->toArray();
        $settings_classification->delete();

        // ✅ log delete
        $this->logActivity('Deleted Settings Classification', [
            'classification' => $dump,
        ]);

        return redirect()->route('settings_classifications.index')
            ->with('success', 'Classification deleted.');
    }

    // Optional quick toggle endpoint
    public function toggle(SettingsClassification $settings_classification)
    {
        $old = $settings_classification->is_active;
        $settings_classification->update(['is_active' => ! $settings_classification->is_active]);

        // ✅ log toggle
        $this->logActivity('Toggled Settings Classification', [
            'classification_id' => $settings_classification->id,
            'old'               => $old,
            'new'               => $settings_classification->is_active,
        ]);

        return back()->with('success', 'Status updated.');
    }

    // Optional: JSON list for AJAX dropdowns
    public function listJson()
    {
        return SettingsClassification::active()
            ->orderBy('name')
            ->get(['id','name','slug']);
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
            'model_type'  => SettingsClassification::class,
            'model_id'    => $changes['classification']['id']
                             ?? $changes['classification_id']
                             ?? null,
            'changes'     => $changes,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
