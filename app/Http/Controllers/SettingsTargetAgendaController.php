<?php

namespace App\Http\Controllers;

use App\Models\SettingsTargetAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');

        SettingsTargetAgenda::create($data);

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

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');

        $settings_target_agenda->update($data);

        return redirect()->route('settings_target_agendas.index')
            ->with('success', 'Target agenda updated.');
    }

    public function destroy(SettingsTargetAgenda $settings_target_agenda)
    {
        $settings_target_agenda->delete();
        return redirect()->route('settings_target_agendas.index')
            ->with('success', 'Target agenda deleted.');
    }

    public function listJson()
    {
        return SettingsTargetAgenda::active()->orderBy('name')->get(['id', 'name', 'slug']);
    }
}
