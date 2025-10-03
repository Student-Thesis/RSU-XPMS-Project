@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')

        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h2>Edit Record / Form</h2>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('forms.update', $form->id) }}" class="mt-3">
                    @csrf
                    @method('PUT')
                    @include('forms._form', ['form' => $form])
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('forms.index') }}" class="btn btn-light">Cancel</a>
                </form>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
