<div class="topbar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="full">
            <button type="button" id="sidebarCollapse" class="sidebar_toggle">
                <i class="fa fa-bars"></i>
            </button>

            <div class="right_topbar">
                <div class="icon_info">
                    <ul>
                        <li>
                            <a href="#"><i class="fa fa-question-circle"></i></a>
                        </li>

                        {{-- 🔔 Notifications --}}
                        <li class="nav-item dropdown">
                            <a data-toggle="dropdown" href="#" data-boundary="viewport">
                                <i class="fa fa-bell-o"></i>
                                <span class="badge">{{ $notificationCount ?? \App\Models\ActivityLog::count() }}</span>
                            </a>

                            {{-- Right-align to toggle so the menu opens leftward and stays on-screen --}}
                            <div id="notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                                style="width:350px">
                                <span class="dropdown-header">Notifications</span>
                                <div id="notification-list" style="max-height:300px; overflow-y:auto;">
                                    @forelse ($notifications ?? [] as $note)
                                        <a href="#" class="dropdown-item">
                                            <i class="fa fa-info-circle mr-2"></i>
                                            {{ $note->action }}
                                            <span
                                                class="float-right text-muted text-sm">{{ $note->created_at->diffForHumans() }}</span>
                                        </a>
                                    @empty
                                        <span class="dropdown-item text-muted">No notifications</span>
                                    @endforelse
                                </div>
                            </div>
                        </li>


                        {{-- ✉️ Messages --}}
                        <li>
                            <a href="{{ route('messages') }}">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge">3</span>
                            </a>
                        </li>
                    </ul>

                    {{-- 👤 User Profile --}}
                    <ul class="user_profile_dd">
                        <li class="dropdown">
                            @php
                                $u = auth()->user();
                                $avatarUrl = $u?->avatar_path
                                    ? asset($basePath . '/' . $u->avatar_path)
                                    : asset($basePath . '/images/layout_img/default_profile.png');
                            @endphp

                            <a class="dropdown-toggle" href="#" id="userMenu" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="img-responsive rounded-circle" src="{{ $avatarUrl }}" alt="Avatar"
                                    width="40" height="40" style="object-fit: cover;" />
                                <span class="name_user">{{ $u?->name ?? 'Guest User' }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
                                <a class="dropdown-item" href="{{ route('settings') }}">Settings</a>
                                <a class="dropdown-item" href="{{ route('help') }}">Help</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span>Log Out</span> <i class="fa fa-sign-out"></i>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>

{{-- CSS Fix --}}
<style>
    /* Make sure the dropdown can overflow the header wrappers */
    .topbar .right_topbar,
    .topbar .icon_info,
    .topbar .icon_info>ul {
        overflow: visible !important;
    }

    /* Ensure the menu stacks over the header */
    #notification-dropdown {
        z-index: 1055;
        /* above navbar content */
    }

    /* If your theme forces left/right, lock it for safety */
    #notification-dropdown.dropdown-menu-right {
        left: auto !important;
        right: 0 !important;
    }

    #notification-dropdown .dropdown-item {
        color: #212529 !important;
        /* Bootstrap default dark text */
        background-color: #fff !important;
        /* keep background white */
    }

    #notification-dropdown .dropdown-item:hover {
        background-color: #f8f9fa !important;
        /* light gray on hover */
        color: #000 !important;
        /* make sure it stays black on hover */
    }

    #notification-dropdown .dropdown-header {
        color: #6c757d !important;
        /* muted gray for header */
    }
</style>
