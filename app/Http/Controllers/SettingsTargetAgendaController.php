<?php

namespace App\Http\Controllers;

use App\Models\SettingsTargetAgenda;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SettingsTargetAgendaController extends Controller
{
    public function index()
    {
        $items = SettingsTargetAgenda::orderBy('name')->paginate(10);
        return view('settings_target_agendas.index', compact('items'));
    }

    public function create()
    {
        return view('settings_target_agendas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:settings_target_agendas,name,NULL,id,deleted_at,NULL',
        ]);

        $data['slug']      = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');

        $agenda = SettingsTargetAgenda::create($data);

        // 🔐 log create
        $this->logActivity('Created Settings Target Agenda', [
            'target_agenda' => $agenda->toArray(),
        ]);

        return redirect()->route('settings_target_agendas.index')
            ->with('success', 'Target agenda created.');
    }

    public function edit(SettingsTargetAgenda $settings_target_agenda)
    {
        return view('settings_target_agendas.edit', compact('settings_target_agenda'));
    }

    public function update(Request $request, SettingsTargetAgenda $settings_target_agenda)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:settings_target_agendas,name,' . $settings_target_agenda->id . ',id,deleted_at,NULL',
        ]);

        $data['slug']      = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');

        $before = $settings_target_agenda->toArray();
        $settings_target_agenda->update($data);
        $after  = $settings_target_agenda->fresh()->toArray();

        // 🔐 log update
        $this->logActivity('Updated Settings Target Agenda', [
            'target_agenda_id' => $settings_target_agenda->id,
            'before'           => $before,
            'after'            => $after,
        ]);

        return redirect()->route('settings_target_agendas.index')
            ->with('success', 'Target agenda updated.');
    }

    public function destroy(SettingsTargetAgenda $settings_target_agenda)
    {
        $dump = $settings_target_agenda->toArray();
        $settings_target_agenda->delete();

        // 🔐 log delete
        $this->logActivity('Deleted Settings Target Agenda', [
            'target_agenda' => $dump,
        ]);

        return redirect()->route('settings_target_agendas.index')
            ->with('success', 'Target agenda deleted.');
    }

    public function listJson()
    {
        return SettingsTargetAgenda::active()
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);
    }

    /**
     * Local logger (no trait)
     */
    protected function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id'          => (string) Str::uuid(),
            'user_id'     => Auth::id(),
            'notifiable_user_id' => Auth::id(),
            'action'      => $action,
            'model_type'  => SettingsTargetAgenda::class,
            'model_id'    => $changes['target_agenda']['id']
                             ?? $changes['target_agenda_id']
                             ?? null,
            'changes'     => $changes,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
