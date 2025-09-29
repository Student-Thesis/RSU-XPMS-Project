@extends('layouts.app')

@section('content')
 <div id="content">
        @include('layouts.partials.topnav')
         <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>Settings</h2>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                  <a href="{{ route('departments.permissions.index') }}" class="btn btn-primary">
                      <i class="fa fa-shield-alt"></i> Manage Department Permissions
                  </a>
              </div>
            </div>

          </div>
        </div>
      </div>
@endsection
