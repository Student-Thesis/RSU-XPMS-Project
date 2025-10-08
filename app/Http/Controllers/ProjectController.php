<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\ActivityLog;               // <-- add
use Illuminate\Support\Facades\Auth;      // <-- add
use Illuminate\Support\Facades\Validator; // <-- add
use Illuminate\Validation\Rule;           // <-- add
use Illuminate\Support\Str;               // <-- add

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // Basic server-side search/filter hooks (optional)
        $q = $request->input('q');
        $college = $request->input('college'); // we’ll map to 'location'
        $status = $request->input('status'); // not in schema; just for future

        $proposals = Proposal::query()
            ->when($q, function ($query, $q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('title', 'like', "%{$q}%")
                        ->orWhere('team_members', 'like', "%{$q}%")
                        ->orWhere('target_agenda', 'like', "%{$q}%")
                        ->orWhere('location', 'like', "%{$q}%")
                        ->orWhere('partner', 'like', "%{$q}%");
                });
            })
            ->when($college && $college !== 'All', function ($query) use ($college) {
                // We’re using 'location' as College/Campus per your table
                $query->where('location', $college);
            })
            // ->when($status && $status !== 'All', ...) // add when you add a status column
            ->latest()
            ->get();

        return view('projects.index', compact('proposals', 'q', 'college', 'status'));
    }

    public function inlineUpdate(Request $request, $project) // receive the raw id
    {
        // Ensure we UPDATE an existing row, not insert
        $model = Proposal::find($project);
        if (!$model) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $booleanCols = [
            'in_house','revised_proposal','ntp','endorsement','proposal_presentation',
            'proposal_documents','program_proposal','project_proposal','moa_mou',
            'activity_design','certificate_of_appearance','attendance_sheet','photos','terminal_report',
        ];
        $enumCols = [
            'classification' => ['Project','Program'],
            'status'         => ['Ongoing','Completed','Cancelled'],
        ];
        $textCols = ['source_of_funds','fund_utilization_rate','documentation_report','code','remarks','drive_link'];
        $numericCols = ['expenditure'];

        $column = $request->input('column');
        $value  = $request->input('value');

        if (!$column) {
            return response()->json(['message' => 'Missing column'], 422);
        }

        // Capture "before" value (only the target column)
        $beforeValue = $model->{$column} ?? null;

        if (in_array($column, $booleanCols, true)) {
            $value = is_string($value) ? strtolower(trim($value)) === 'yes' : (bool)$value;
            $model->{$column} = $value;

        } elseif (array_key_exists($column, $enumCols)) {
            $v = Validator::make(['value' => $value], ['value' => ['required', Rule::in($enumCols[$column])]]);
            if ($v->fails()) return response()->json(['message' => 'Invalid value'], 422);
            $model->{$column} = $value;

        } elseif (in_array($column, $textCols, true)) {
            $v = Validator::make(['value' => $value], ['value' => ['nullable','string','max:1000']]);
            if ($v->fails()) return response()->json(['message' => 'Invalid text'], 422);
            $model->{$column} = $value ?: null;

        } elseif (in_array($column, $numericCols, true)) {
            $normalized = is_null($value) ? null : preg_replace('/[^\d.\-]/', '', (string)$value);
            if ($normalized === '') $normalized = null;
            $v = Validator::make(['value' => $normalized], ['value' => ['nullable','numeric','min:0']]);
            if ($v->fails()) return response()->json(['message' => 'Invalid number'], 422);
            $model->{$column} = $normalized;

        } else {
            return response()->json(['message' => 'Column not allowed'], 422);
        }

        $model->save();

        // ===== Activity Log =====
        try {
            ActivityLog::create([
                'id'          => (string) Str::uuid(),
                'user_id'     => Auth::id(),
                'action'      => 'Inline Update (Project)',
                'model_type'  => Proposal::class,
                'model_id'    => $model->id,
                'changes'     => [
                    'column' => $column,
                    'before' => $beforeValue,
                    'after'  => $model->{$column},
                    'via'    => 'projects.inlineUpdate',
                ],
                'ip_address'  => $request->ip(),
                'user_agent'  => $request->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Don't block the user action if logging fails; optionally report
            report($e);
        }

        return response()->json([
            'message' => 'Updated',
            'column'  => $column,
            'value'   => $model->{$column},
        ]);
    }
}
