<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AgreementController extends Controller
{
    public function register()
    {
        return view('agreements.register');
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
            $data = $request->validate([
                'organization_name' => ['nullable', 'string', 'max:255'],
                'date_signed'       => ['nullable', 'date'],
                'mouFile'           => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
                'moaFile'           => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
            ]);

            // Check if user submitted *any* data
            $hasAnyData = !empty($data['organization_name']) ||
                          !empty($data['date_signed']) ||
                          $request->hasFile('mouFile') ||
                          $request->hasFile('moaFile');

            if (!$hasAnyData) {
                return redirect()
                    ->route('notifications.agreement')
                    ->with('info', 'Thank you. Admin will review your application.');
            }

            // Build payload (only include provided fields)
            $payload = [
                'user_id' => auth()->id(),
            ];

            if (!empty($data['organization_name'])) {
                $payload['organization_name'] = $data['organization_name'];
            }

            if (!empty($data['date_signed'])) {
                $payload['date_signed'] = $data['date_signed'];
            }

            if ($request->hasFile('mouFile')) {
                $payload['mou_path'] = $request->file('mouFile')->storeAs(
                    'agreements',
                    self::uniqueName($request->file('mouFile')),
                    'public'
                );
            }

            if ($request->hasFile('moaFile')) {
                $payload['moa_path'] = $request->file('moaFile')->storeAs(
                    'agreements',
                    self::uniqueName($request->file('moaFile')),
                    'public'
                );
            }

            $agreement = Agreement::create($payload);

            // ✅ Log upload success
            $this->logActivity('Created Agreement', [
                'agreement' => $agreement->toArray(),
            ]);

            return redirect()
                ->route('notifications.agreement')
                ->with('success', 'Documents uploaded successfully.');
        } catch (\Throwable $e) {
            \Log::error('Agreement upload failed', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'input'   => $request->except(['mouFile', 'moaFile']),
                'user_id' => auth()->id(),
            ]);

            // ❌ Log failure attempt too (optional)
            $this->logActivity('Agreement Upload Failed', [
                'error' => $e->getMessage(),
                'input' => $request->except(['mouFile', 'moaFile']),
            ]);

            return back()->withInput()->with('error', 'Upload failed. Please try again.');
        }
    }

    // Helper to generate collision-safe filenames
    protected static function uniqueName(\Illuminate\Http\UploadedFile $file): string
    {
        $ext  = $file->getClientOriginalExtension();
        $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        return Str::slug($base) . '-' . Str::random(8) . '.' . strtolower($ext);
    }

    /**
     * 🧾 Local logging method (same as in CalendarEventController)
     */
    protected function logActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'id'          => Str::uuid(),
            'user_id'     => Auth::id(),
            'notifiable_user_id' => Auth::id(),
            'action'      => $action,
            'model_type'  => Agreement::class,
            'model_id'    => $changes['agreement']['id'] ?? null,
            'changes'     => $changes,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
