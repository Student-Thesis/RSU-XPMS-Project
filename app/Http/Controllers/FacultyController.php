<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $college = $request->get('college');

        $query = Faculty::query();

        if ($q) {
            $query->where(function($w) use ($q) {
                $w->where('campus_college', 'like', "%{$q}%")
                  ->orWhere('num_faculties', 'like', "%{$q}%");
            });
        }

        if ($college && $college !== 'All') {
            $query->where('campus_college', $college);
        }

        $rows = $query->orderBy('campus_college')->paginate(20)->withQueryString();

        return view('faculties.index', [
            'rows' => $rows,
            'q' => $q,
            'college' => $college,
        ]);
    }

    public function create()
    {
        return view('faculties.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Faculty::create($data);

        return redirect()->route('faculties.index')->with('success', 'Record created.');
    }

    public function edit(Faculty $faculty)
    {
        return view('faculties.edit', ['item' => $faculty]);
    }

    public function update(Request $request, Faculty $faculty)
    {
        $data = $this->validated($request);
        $faculty->update($data);

        return redirect()->route('faculties.index')->with('success', 'Record updated.');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('faculties.index')->with('success', 'Record deleted.');
    }

    private function validated(Request $request): array
    {
        $int = 'nullable|integer|min:0';

        return $request->validate([
            'campus_college' => ['required','string','max:255'],
            'num_faculties'  => $int,

            'involved_extension_total' => $int,
            'involved_extension_q1'    => $int,
            'involved_extension_q2'    => $int,
            'involved_extension_q3'    => $int,
            'involved_extension_q4'    => $int,

            'iec_developed_total' => $int,
            'iec_developed_q1'    => $int,
            'iec_developed_q2'    => $int,
            'iec_developed_q3'    => $int,
            'iec_developed_q4'    => $int,

            'iec_reproduced_total' => $int,
            'iec_reproduced_q1'    => $int,
            'iec_reproduced_q2'    => $int,
            'iec_reproduced_q3'    => $int,
            'iec_reproduced_q4'    => $int,

            'iec_distributed_total' => $int,
            'iec_distributed_q1'    => $int,
            'iec_distributed_q2'    => $int,
            'iec_distributed_q3'    => $int,
            'iec_distributed_q4'    => $int,

            'proposals_approved_total' => $int,
            'proposals_approved_q1'    => $int,
            'proposals_approved_q2'    => $int,
            'proposals_approved_q3'    => $int,
            'proposals_approved_q4'    => $int,

            'proposals_implemented_total' => $int,
            'proposals_implemented_q1'    => $int,
            'proposals_implemented_q2'    => $int,
            'proposals_implemented_q3'    => $int,
            'proposals_implemented_q4'    => $int,

            'proposals_documented_total' => $int,
            'proposals_documented_q1'    => $int,
            'proposals_documented_q2'    => $int,
            'proposals_documented_q3'    => $int,
            'proposals_documented_q4'    => $int,

            'community_served_total' => $int,
            'community_served_q1'    => $int,
            'community_served_q2'    => $int,
            'community_served_q3'    => $int,
            'community_served_q4'    => $int,

            'beneficiaries_assistance_total' => $int,
            'beneficiaries_assistance_q1'    => $int,
            'beneficiaries_assistance_q2'    => $int,
            'beneficiaries_assistance_q3'    => $int,
            'beneficiaries_assistance_q4'    => $int,

            'moa_mou_total' => $int,
            'moa_mou_q1'    => $int,
            'moa_mou_q2'    => $int,
            'moa_mou_q3'    => $int,
            'moa_mou_q4'    => $int,
        ]);
    }
}
