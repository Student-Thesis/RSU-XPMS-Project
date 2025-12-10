@extends('layouts.app')

@section('content')

    @php
        $campusOptions = [
            'CAS', 'CBA', 'CET', 'CAFES', 'CCMADI', 'CED', 'GEPS',
            'CALATRAVA CAMPUS', 'STA. MARIA CAMPUS', 'SANTA FE CAMPUS',
            'SAN ANDRES CAMPUS', 'SAN AGUSTIN CAMPUS', 'ROMBLON CAMPUS',
            'CAJIDIOCAN CAMPUS', 'SAN FERNANDO CAMPUS',
        ];

        // Reusable metric row generator (same as create, but with $item values)
        $metric = function (string $label, string $prefix, $item) {
            $html  = '<div class="col-12 mt-3"><h5 class="mb-2 fw-semibold">' . e($label) . '</h5></div>';

            // Total (READONLY)
            $html .= '
                <div class="col-md-3">
                    <label class="form-label">Total</label>
                    <input type="number"
                           name="' . e($prefix . '_total') . '"
                           class="form-control form-control-sm metric-total"
                           value="' . e(old($prefix . '_total', $item->{$prefix . '_total'} ?? 0)) . '"
                           min="0"
                           readonly>
                </div>';

            // Q1–Q4
            foreach (['q1', 'q2', 'q3', 'q4'] as $q) {
                $field = $prefix . '_' . $q;

                $html .= '
                    <div class="col-md-2">
                        <label class="form-label text-uppercase">' . e($q) . '</label>
                        <input type="number"
                               name="' . e($field) . '"
                               class="form-control form-control-sm metric-quarter"
                               value="' . e(old($field, $item->{$field} ?? 0)) . '"
                               min="0">
                    </div>';
            }

            return $html;
        };
    @endphp

    {{-- HEADER (AdminLTE style, like create) --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-9">
                    <h3 class="mb-0">
                        EXTENSION PERFORMANCE INDICATORS AND TARGETS
                        <small class="text-muted d-block d-sm-inline">Edit Record</small>
                    </h3>
                </div>
                <div class="col-sm-3 text-sm-end mt-2 mt-sm-0">
                    <a href="{{ route('faculties.index') }}" class="btn btn-warning btn-sm">
                        <i class="fa fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="app-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('faculties.update', $item) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- CAMPUS / COLLEGE - same style as create (select) --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    Campus / College <span class="text-danger">*</span>
                                </label>
                                <select name="campus_college" class="form-select form-select-sm" required>
                                    <option value="">— Select Campus / College —</option>
                                    @foreach ($campusOptions as $opt)
                                        <option value="{{ $opt }}"
                                            {{ old('campus_college', $item->campus_college) === $opt ? 'selected' : '' }}>
                                            {{ $opt }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('campus_college')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- FACULTIES --}}
                            <div class="col-md-6">
                                <label class="form-label">Faculties</label>
                                <input type="number"
                                       name="num_faculties"
                                       class="form-control form-control-sm"
                                       value="{{ old('num_faculties', $item->num_faculties) }}"
                                       min="0">
                                @error('num_faculties')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <hr class="my-3">

                            {{-- METRICS (same as create) --}}
                            {!! $metric('Involved in Extension (60% - 173)', 'involved_extension', $item) !!}
                            {!! $metric('IEC Materials Developed (25)', 'iec_developed', $item) !!}
                            {!! $metric('IEC Materials Reproduced (600)', 'iec_reproduced', $item) !!}
                            {!! $metric('IEC Materials Distributed (600)', 'iec_distributed', $item) !!}
                            {!! $metric('Quality Extension Proposals Approved (13)', 'proposals_approved', $item) !!}
                            {!! $metric('Quality Extension Proposals Implemented (13)', 'proposals_implemented', $item) !!}
                            {!! $metric('Quality Extension Proposals Documented (13)', 'proposals_documented', $item) !!}
                            {!! $metric('Community Population Served (5,939)', 'community_served', $item) !!}
                            {!! $metric('Beneficiaries of Technical Assistance (813)', 'beneficiaries_assistance', $item) !!}
                            {!! $metric('MOA/MOU Signed (8)', 'moa_mou', $item) !!}

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i> Update Record
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // 1) Allow ONLY digits 0–9 in all number inputs
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/\D+/g, ''); // strip non-digits
        });
    });

    // 2) Auto-sum Q1–Q4 into Total for each metric group
    function updateTotals() {
        document.querySelectorAll('.metric-total').forEach(totalField => {
            const prefix = totalField.name.replace('_total', '');

            const q1 = document.querySelector(`[name="${prefix}_q1"]`)?.value || 0;
            const q2 = document.querySelector(`[name="${prefix}_q2"]`)?.value || 0;
            const q3 = document.querySelector(`[name="${prefix}_q3"]`)?.value || 0;
            const q4 = document.querySelector(`[name="${prefix}_q4"]`)?.value || 0;

            const sum = (+q1) + (+q2) + (+q3) + (+q4);
            totalField.value = sum;
        });
    }

    // Bind listeners on all quarter inputs
    document.querySelectorAll('.metric-quarter').forEach(input => {
        input.addEventListener('input', updateTotals);
    });

    // Initial calculation on page load (for existing $item values)
    updateTotals();
});
</script>
@endpush
