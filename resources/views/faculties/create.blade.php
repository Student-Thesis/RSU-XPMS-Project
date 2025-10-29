@extends('layouts.app')

@section('content')
<div id="content">
    @include('layouts.partials.topnav')

    <div class="midde_cont">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Create Record</h3>
                <a href="{{ route('faculties.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>

            <form method="POST" action="{{ route('faculties.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Campus/College <span class="text-danger">*</span></label>
                        <input type="text" name="campus_college" class="form-control" value="{{ old('campus_college') }}" required>
                        @error('campus_college') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Faculties</label>
                        <input type="number" name="num_faculties" class="form-control" value="{{ old('num_faculties', 0) }}" min="0">
                        @error('num_faculties') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <hr class="my-3">

                    @php
                        $metric = function($label, $prefix) {
                            $out  = '<div class="col-12"><h5 class="mt-2">'.$label.'</h5></div>';
                            $out .= '<div class="col-md-3"><label class="form-label">Total</label>
                                     <input type="number" name="'.$prefix.'_total" class="form-control" value="'.e(old($prefix.'_total',0)).'" min="0"></div>';
                            foreach (['q1','q2','q3','q4'] as $q) {
                                $out .= '<div class="col-md-2"><label class="form-label">'.strtoupper($q).'</label>
                                         <input type="number" name="'.$prefix.'_'.$q.'" class="form-control" value="'.e(old($prefix.'_'.$q,0)).'" min="0"></div>';
                            }
                            return $out;
                        };
                    @endphp

                    {!! $metric('Involved in Extension (60% - 173)', 'involved_extension') !!}
                    {!! $metric('IEC Materials Developed (25)', 'iec_developed') !!}
                    {!! $metric('IEC Materials Reproduced (600)', 'iec_reproduced') !!}
                    {!! $metric('IEC Materials Distributed (600)', 'iec_distributed') !!}
                    {!! $metric('Quality Extension Proposals Approved (13)', 'proposals_approved') !!}
                    {!! $metric('Quality Extension Proposals Implemented (13)', 'proposals_implemented') !!}
                    {!! $metric('Quality Extension Proposals Documented (13)', 'proposals_documented') !!}
                    {!! $metric('Community Population Served (5,939)', 'community_served') !!}
                    {!! $metric('Beneficiaries of Technical Assistance (813)', 'beneficiaries_assistance') !!}
                    {!! $metric('MOA/MOU Signed (8)', 'moa_mou') !!}
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
