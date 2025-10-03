        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar_blog_1">
                <div class="sidebar-header">
                    <div class="logo_section">
                        <a href="{{ url('index.html') }}">
    <img class="logo_icon img-responsive" src="{{ asset($basePath . '/images/logo/logo.png') }}" alt="Logo" />
</a>

                    </div>
                </div>
                <div class="sidebar_user_info">
                    <div class="icon_setting"></div>
                    <div class="user_profle_side">
                        <div class="user_img"><img class="img-responsive" src="{{ asset($basePath . '/images/logo/logo.jpg') }}" alt="Logo" />

                        </div>
                        <div class="user_info">
                            <h2>ESCEO</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebar_blog_2">

                <ul class="list-unstyled components">
                    <li class="active">
                        <a href="{{route('dashboard')}}">
                            <i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('projects')}}">
                            <i class="fa fa-table green_color"></i> <span>Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('forms.index')}}">
                            <i class="fa fa-edit orange_color"></i> <span>Forms</span>
                        </a>
                    </li>
                    <li>
                         <a href="{{route('faculty')}}">
                            <i class="fa fa-edit yellow_color"></i> <span>Faculty</span>
                        </a>
                    </li>
                    <!-- Users Dropdown -->
                    <li>
                        <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-user blue2_color"></i> <span>Users</span>
                        </a>
                        <ul class="collapse list-unstyled" id="userSubmenu">
                            <li>
                                <a href="{{route('users.create')}}"><i class="fa fa-plus-circle"></i> Add User</a>
                            </li>
                            <li>
                                <a href="{{route('users.index')}}"><i class="fa fa-list"></i> List of Users</a>
                            </li>

                        </ul>
                        <a href="{{route('calendar')}}">
                            <i class="fa fa-calendar red_color"></i> <span>Calendar</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- end sidebar -->