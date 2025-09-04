@extends('layouts.app')

@section('content')
  <div id="content">
       @include('layouts.partials.topnav')

        <!-- Main Content -->
        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title d-flex justify-content-between align-items-center">
                            <h2 style="margin-left: 10px;">User List</h2>

                            <a href="New_user.html" class="btn btn-outline-primary"><i class="fa fa-plus"></i> Add
                                New User</a>
                        </div>
                    </div>
                </div>

                <div class="filter-bar">
                    <input type="text" placeholder="Search anything..." />
                    <select>
                        <option>Filter by Role</option>
                        <option>Admin</option>
                        <option>Viewer</option>
                        <option>Project Manager</option>
                    </select>
                </div>

                <div class="white_shd full margin_bottom_30">
                    <div class="full">
                        <div class="table_section padding_infor_info">
                            <div class="table-responsive">
                                <table class="table table-bordered custom-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Sample User</td>
                                            <td>sampleuser@email.com</td>
                                            <td>Viewer</td>
                                            <td><button class="btn btn-outline-info dropdown-toggle">Action</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Content -->
    </div>
@endsection