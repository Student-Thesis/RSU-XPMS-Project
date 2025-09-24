{{-- resources/views/debug/form.blade.php --}}
@extends('layouts.app')
@section('content')
  <form method="POST" action="/debug/form">
    @csrf
    <button class="btn btn-primary">Test POST</button>
  </form>
@endsection
