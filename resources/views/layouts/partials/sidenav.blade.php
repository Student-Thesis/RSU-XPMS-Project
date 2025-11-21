<!-- Sidebar  -->
<nav id="sidebar">
    <div class="sidebar_blog_1">
        <div class="sidebar-header">
            <div class="logo_section">
                <a href="{{ url('index.html') }}">
                    <img class="logo_icon img-responsive"
                         src="{{ asset($basePath . '/images/logo/logo.png') }}"
                         alt="Logo" />
                </a>
            </div>
        </div>

        <div class="sidebar_user_info">
            <div class="icon_setting"></div>
            <div class="user_profle_side">
                <div class="user_img">
                    <img class="img-responsive"
                         src="{{ asset($basePath . '/images/logo/logo.jpg') }}"
                         alt="Logo" />
                </div>
                <div class="user_info">
                    <h2>ESCEO</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="sidebar_blog_2">
        <ul class="list-unstyled components">
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard yellow_color"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('projects*') ? 'active' : '' }}">
                <a href="{{ route('projects') }}">
                    <i class="fa fa-folder-open green_color"></i>
                    <span>Projects</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('forms.*') ? 'active' : '' }}">
                <a href="{{ route('forms.index') }}">
                    <i class="fa fa-file orange_color"></i>
                    <span>Forms</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('faculties') ? 'active' : '' }}">
                <a href="{{ route('faculties.index') }}">
                    <i class="fa fa-graduation-cap yellow_color"></i>
                    <span>Faculty</span>
                </a>
            </li>

            @php
                $userType = auth()->user()->user_type ?? null;
            @endphp

            @if (in_array($userType, ['root', 'admin']))
                <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-users blue2_color"></i>
                        <span>Users</span>
                    </a>
                    <ul class="collapse list-unstyled {{ request()->routeIs('users.*') ? 'show' : '' }}"
                        id="userSubmenu">
                        <li>
                            <a href="{{ route('users.create') }}">
                                <i class="fa fa-user-plus"></i> Add User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}">
                                <i class="fa fa-list-ul"></i> List of Users
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="{{ request()->routeIs('calendar') ? 'active' : '' }}">
                <a href="{{ route('calendar') }}">
                    <i class="fa fa-calendar red_color"></i>
                    <span>Calendar</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
<!-- end sidebar -->

{{-- SIDEBAR MINI CSS --}}
<style>
    /* default sidebar */
    #sidebar {
        width: 250px;
        transition: width 0.3s ease;
    }

    /* collapse button – no background */
    #sidebarCollapse.sidebar_toggle {
        background: none !important;
        border: none !important;
        box-shadow: none !important;
        padding: 5px 8px;
        cursor: pointer;
    }

    #sidebarCollapse.sidebar_toggle:focus {
        outline: none !important;
    }

    /* mini mode: shrink width */
    #sidebar.sidebar-mini {
        width: 70px !important;
        overflow: hidden;
    }

    /* hide username + settings in mini */
    #sidebar.sidebar-mini .sidebar_user_info .user_info,
    #sidebar.sidebar-mini .sidebar_user_info .icon_setting {
        display: none !important;
    }

    /* center avatar in mini */
    #sidebar.sidebar-mini .sidebar_user_info .user_img {
        margin: 0 auto;
        display: block;
    }

    /* hide menu text in mini */
    #sidebar.sidebar-mini .sidebar_blog_2 ul.components li a span {
        display: none !important;
    }

    /* center icons when mini */
    #sidebar.sidebar-mini .sidebar_blog_2 ul.components li a {
        text-align: center;
        padding-left: 0;
        padding-right: 0;
    }

    #sidebar.sidebar-mini .sidebar_blog_2 ul.components li a i {
        margin-right: 0 !important;
        font-size: 20px;
        width: 100%;
    }
    /* Make sidebar + content lie side-by-side */
.inner_container {
    display: flex;
    flex-direction: row;
}

/* Sidebar default width */
#sidebar {
    width: 250px;
    transition: width 0.3s ease;
    flex-shrink: 0; /* prevents collapsing */
}

/* Content area takes full remaining space */
.content-area {
    flex: 1;
    width: 100%;
    transition: margin-left 0.3s ease;
}

/* When sidebar collapses */
#sidebar.sidebar-mini {
    width: 70px !important;
}

</style>

{{-- SIDEBAR MINI TOGGLE --}}
<script>
    $(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('sidebar-mini');

            // Update PerfectScrollbar if it exists
            if (typeof ps !== 'undefined') {
                ps.update();
            }
        });
    });
</script>
