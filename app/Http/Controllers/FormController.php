<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RecordForm;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function index()
    {
        $forms = RecordForm::query()
            ->orderBy('display_order')
            ->orderBy('record_code')
            ->get();

        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        return view('forms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'record_code'        => ['required', 'string', 'max:50', 'unique:record_forms,record_code'],
            'title'              => ['required', 'string', 'max:255'],
            'link_url'           => ['required', 'url', 'max:2048'],
            'maintenance_years'  => ['required', 'integer', 'min:0', 'max:100'],
            'preservation_years' => ['required', 'integer', 'min:0', 'max:100'],
            'remarks'            => ['nullable', 'string', 'max:255'],
            'display_order'      => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active'          => ['nullable', 'boolean'],
        ]);

        $data['is_active']     = (bool) ($data['is_active'] ?? true);
        $data['display_order'] = $data['display_order'] ?? 0;

        $form = RecordForm::create($data);

        // 🔐 log create
        $this->logActivity('Created Record Form', [
            'form' => $form->toArray(),
        ]);

        return redirect()->route('forms.index')->with('success', 'Record created.');
    }

    public function edit(RecordForm $form)
    {
        return view('forms.edit', ['form' => $form]);
    }

    public function update(Request $request, RecordForm $form)
    {
        $data = $request->validate([
            'record_code' => [
                'required','string','max:50',
                Rule::unique('record_forms','record_code')
                    ->ignore($form->getKey(), $form->getKeyName())
                    ->whereNull('deleted_at'),
            ],
            'title'               => ['required','string','max:255'],
            'link_url'            => ['required','url','max:2048'],
            'maintenance_years'   => ['required','integer','min:0','max:100'],
            'preservation_years'  => ['required','integer','min:0','max:100'],
            'remarks'             => ['nullable','string','max:255'],
            'display_order'       => ['nullable','integer','min:0','max:65535'],
            'is_active'           => ['nullable','boolean'],
        ]);

        $data['is_active']     = (bool)($data['is_active'] ?? true);
        $data['display_order'] = $data['display_order'] ?? 0;

        $before = $form->toArray();
        $form->update($data);
        $after = $form->fresh()->toArray();

        // 🔐 log update
        $this->logActivity('Updated Record Form', [
            'form_id' => $form->id,
            'before'  => $before,
            'after'   => $after,
        ]);

        return redirect()->route('forms.index')->with('success','Record updated.');
    }

    public function destroy(RecordForm $record_form)
    {
        $dump = $record_form->toArray();
        $record_form->delete();

        // 🔐 log delete
        $this->logActivity('Deleted Record Form', [
            'form' => $dump,
        ]);

        return redirect()->route('forms.index')->with('success', 'Record deleted.');
    }

    /**
     * Local logger for this controller
     */
    protected function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id'          => Str::uuid(),
            'user_id'     => Auth::id(),
            'notifiable_user_id' => Auth::id(),
            'action'      => $action,
            'model_type'  => RecordForm::class,
            'model_id'    => $changes['form']['id'] 
                             ?? $changes['form_id'] 
                             ?? null,
            'changes'     => $changes,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
