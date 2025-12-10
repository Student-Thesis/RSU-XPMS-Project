@php
    use App\Support\DeptGate;
    $user = auth()->user();
@endphp

<aside class="app-sidebar sidebar-bg shadow" data-bs-theme="dark">
    <div class="sidebar-brand" style="background:green;">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ $basePath }}/images/logo/logo.png" alt="ESCEO Logo"
                 class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">ESCEO</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" 
                data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false">

                {{-- DASHBOARD --}}
                @if (DeptGate::can($user, 'dashboard', 'view') || true)
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2" style="color:orange"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif

                {{-- PROJECTS --}}
                @if (DeptGate::can($user, 'project', 'view'))
                    <li class="nav-item">
                        <a href="{{ route('projects') }}"
                           class="nav-link {{ request()->routeIs('projects*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-folder2-open" style="color:rgb(0, 228, 187)"></i>
                            <p>Projects</p>
                        </a>
                    </li>
                @endif

                {{-- FORMS --}}
                @if (DeptGate::can($user, 'forms', 'view'))
                    <li class="nav-item">
                        <a href="{{ route('forms.index') }}"
                           class="nav-link {{ request()->routeIs('forms.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-file-earmark-text" style="color:rgb(209, 105, 0)"></i>
                            <p>Forms</p>
                        </a>
                    </li>
                @endif

                {{-- FACULTY --}}
                @if (DeptGate::can($user, 'faculty', 'view'))
                    <li class="nav-item">
                        <a href="{{ route('faculties.index') }}"
                           class="nav-link {{ request()->routeIs('faculties*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-mortarboard" style="color:orange"></i>
                            <p>Faculty</p>
                        </a>
                    </li>
                @endif

                {{-- USERS --}}
                @if (DeptGate::can($user, 'users', 'view'))
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                           class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people-fill" style="color:rgb(26, 255, 0)"></i>
                            <p>Users</p>
                        </a>
                    </li>
                @endif

                {{-- CALENDAR --}}
                @if (DeptGate::can($user, 'calendar', 'view'))
                    <li class="nav-item">
                        <a href="{{ route('calendar') }}"
                           class="nav-link {{ request()->routeIs('calendar') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-calendar-week" style="color:rgb(223, 0, 0)"></i>
                            <p>Calendar</p>
                        </a>
                    </li>
                @endif

            </ul>
        </nav>
    </div>
</aside>

<style>
    /* Apply geometric dark background */
    .sidebar-bg {
        background-image: url("/images/nav.png");
        background-size: cover;
        background-repeat: repeat-y;
        background-position: center center;
    }

 

      /* -------------------------------------
   FIX ICONS WHEN SIDEBAR IS COLLAPSED
   (App layout: .app-sidebar / AdminLTE 4 style)
-------------------------------------- */

    /* collapsed width */
    .sidebar-mini.sidebar-collapse .app-sidebar {
        width: 4.6rem !important;
    }

    /* hide text but keep icons */
    .sidebar-mini.sidebar-collapse .nav-sidebar .nav-link p {
        display: none !important;
    }

    /* center icons */
    .sidebar-mini.sidebar-collapse .nav-sidebar .nav-link {
        justify-content: center;
        text-align: center;
        padding-left: 0.6rem !important;
    }

    /* icons look cleaner and centered */
    .sidebar-mini.sidebar-collapse .nav-sidebar .nav-link .nav-icon {
        margin-right: 0 !important;
        font-size: 1.25rem;
        /* optional, slightly larger icons */
    }

    /* hide right caret/arrow when collapsed */
    .sidebar-mini.sidebar-collapse .nav-sidebar .nav-icon+p .right,
    .sidebar-mini.sidebar-collapse .nav-sidebar .right {
        display: none !important;
    }
</style>
