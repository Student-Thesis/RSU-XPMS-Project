<div class="topbar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="full">
            <button type="button" id="sidebarCollapse" class="sidebar_toggle">
                <i class="fa fa-bars"></i>
            </button>

            <div class="right_topbar">
                <div class="icon_info">
                    <ul>
                        {{-- <li>
                            <a href="#"><i class="fa fa-question-circle"></i></a>
                        </li> --}}

                        {{-- 🔔 Notifications --}}
                       <li class="nav-item dropdown position-static">
    <a href="#" class="nav-link" data-bs-toggle="dropdown" data-boundary="viewport">
        <i class="fa fa-bell-o"></i>
        <span class="badge">{{ $notificationCount ?? \App\Models\ActivityLog::count() }}</span>
    </a>

    <div id="notification-dropdown"
         class="dropdown-menu dropdown-menu-end shadow-sm"
         style="width:350px; max-height:300px; overflow-y:auto;">
        <span class="dropdown-header">Notifications</span>

        @forelse ($notifications ?? [] as $note)
            <a href="#" class="dropdown-item d-flex justify-content-between align-items-start">
                <span><i class="fa fa-info-circle me-2"></i> {{ $note->action }}</span>
                <span class="text-muted text-sm">{{ $note->created_at->diffForHumans() }}</span>
            </a>
        @empty
            <span class="dropdown-item text-muted">No notifications</span>
        @endforelse
    </div>
</li>

                        {{-- ✉️ Messages --}}
                        {{-- <li>
                            <a href="{{ route('messages') }}">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge">3</span>
                            </a>
                        </li> --}}
                    </ul>

                    {{-- 👤 User Profile --}}
                    <ul class="user_profile_dd" style="z-index: 999999999999999999999999">
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
    /* allow overflow like you already did */
    .topbar .right_topbar,
    .topbar .icon_info,
    .topbar .icon_info > ul {
        overflow: visible !important;
    }

    /* make ONLY the notifications dropdown layouted */
    #notification-dropdown {
        position: static !important;     /* <— this is the main fix */
        inset: auto !important;          /* remove top/right auto-pos from BS */
        z-index: 9999999999999999999999999999999;
        background: #fff;
    }

    /* keep right alignment look even if static */
    .nav-item.dropdown.position-static {
        position: static !important;
    }
    .nav-item.dropdown.position-static > .dropdown-menu {
        margin-left: auto;               /* push to the right */
    }

    #notification-dropdown .dropdown-item {
        color: #212529 !important;
        background-color: #fff !important;
    }
    #notification-dropdown .dropdown-item:hover {
        background-color: #f8f9fa !important;
        color: #000 !important;
    }
</style>
