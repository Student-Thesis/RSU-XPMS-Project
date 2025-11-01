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
         class="dropdown-menu dropdown-menu-end dropdown-menu-start shadow-sm"
         style="width:350px; max-height:300px; overflow-y:auto; right:0; left:auto;">
        <span class="dropdown-header small fw-bold px-3">Notifications</span>

        @forelse ($notifications ?? [] as $note)
            <a href="#"
               class="dropdown-item py-2 d-flex justify-content-between align-items-start">
                <span class="small">
                    <i class="fa fa-info-circle me-2 text-secondary"></i>
                    {{ $note->action }}
                </span>
                <span class="text-muted text-xs">{{ $note->created_at->diffForHumans() }}</span>
            </a>
        @empty
            <span class="dropdown-item text-muted small">No notifications</span>
        @endforelse
    </div>
</li>
<style>
    /* Force dropdown to open toward the left */
#notification-dropdown {
    left: auto !important;
    right: 0 !important;
    transform: translateX(-60%); /* adjust this if still too far right */
}

/* Smaller font for notification items */
#notification-dropdown .dropdown-item span {
    font-size: 0.8rem;
    line-height: 1.2;
}

#notification-dropdown .dropdown-header {
    font-size: 0.85rem;
    background: #f8f9fa;
    color: #555;
}

/* Make badge smaller and better aligned */
.nav-link .badge {
    font-size: 0.65rem;
    padding: 2px 6px;
    vertical-align: top;
}

</style>

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

                                @if (auth()->check() && in_array(auth()->user()->user_type, ['admin', 'root']))
                                    <a class="dropdown-item" href="{{ route('settings') }}">Settings</a>
                                @endif

                                {{-- <a class="dropdown-item" href="{{ route('help') }}">Help</a> --}}

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
    .topbar .icon_info>ul {
        overflow: visible !important;
    }

    /* make ONLY the notifications dropdown layouted */
    #notification-dropdown {
        position: static !important;
        /* <— this is the main fix */
        inset: auto !important;
        /* remove top/right auto-pos from BS */
        z-index: 9999999999999999999999999999999;
        background: #fff;
    }

    /* keep right alignment look even if static */
    .nav-item.dropdown.position-static {
        position: static !important;
    }

    .nav-item.dropdown.position-static>.dropdown-menu {
        margin-left: auto;
        /* push to the right */
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
