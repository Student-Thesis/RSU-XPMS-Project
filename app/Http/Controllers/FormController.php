<?php

// app/Http/Controllers/Admin/RecordFormController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RecordForm;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FormController extends Controller
{
    public function index()
    {
        $forms = RecordForm::query()->orderBy('display_order')->orderBy('record_code')->get();

        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        return view('forms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'record_code' => ['required', 'string', 'max:50', 'unique:record_forms,record_code'],
            'title' => ['required', 'string', 'max:255'],
            'link_url' => ['required', 'url', 'max:2048'],
            'maintenance_years' => ['required', 'integer', 'min:0', 'max:100'],
            'preservation_years' => ['required', 'integer', 'min:0', 'max:100'],
            'remarks' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool) ($data['is_active'] ?? true);
        $data['display_order'] = $data['display_order'] ?? 0;

        RecordForm::create($data);

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
                    ->ignore($form->getKey(), $form->getKeyName()) // safe ignore
                    ->whereNull('deleted_at'),                     // exclude soft-deleted
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

        $form->update($data);

        return redirect()->route('forms.index')->with('success','Record updated.');
    }

    public function destroy(RecordForm $record_form)
    {
        $record_form->delete();
        return redirect()->route('forms.index')->with('success', 'Record deleted.');
    }
}
