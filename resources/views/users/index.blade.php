@extends('layouts.app')

@section('content')
  <div id="content">
        <div class="topbar">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="full">
                    <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i
                            class="fa fa-bars"></i></button>
                    <div class="logo_section">
                        <a href="index.html"><img class="img-responsive" src="images/logo/logo.png"
                                alt="#" /></a>
                    </div>
                    <div class="right_topbar">
                        <div class="icon_info">
                            <ul>
                                <li><a href="#"><i class="fa fa-bell-o"></i><span class="badge">2</span></a></li>
                                <li><a href="#"><i class="fa fa-question-circle"></i></a></li>
                                <li><a href="#"><i class="fa fa-envelope-o"></i><span class="badge">3</span></a>
                                </li>
                            </ul>
                            <ul class="user_profile_dd">
                                <li>
                                    <a class="dropdown-toggle" data-toggle="dropdown">
                                        <img class="img-responsive rounded-circle" src="images/layout_img/user_img.jpg"
                                            alt="#" />
                                        <span class="name_user">John David</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="profile.html">My Profile</a>
                                        <a class="dropdown-item" href="settings.html">Settings</a>
                                        <a class="dropdown-item" href="help.html">Help</a>
                                        <a class="dropdown-item" href="#"><span>Log Out</span> <i
                                                class="fa fa-sign-out"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

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