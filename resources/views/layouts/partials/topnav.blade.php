<div class="topbar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="full">
            <button type="button" id="sidebarCollapse" class="sidebar_toggle">
                <i class="fa fa-bars"></i>
            </button>

            <div class="right_topbar">
                <div class="icon_info">
                    <ul>
                         <li class="nav-item">
                            <a href="{{route('messages')}}" class="nav-link position-relative">
                                <i class="fa fa-envelope" ></i>
                            </a>
                        </li>
                        {{-- 🔔 Notifications --}}
                        <li class="nav-item dropdown" id="notif-wrapper">
                            <a href="#" class="nav-link position-relative" id="notificationDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell-o"></i>

                                @php
                                    $count = $notificationCount
                                        ?? \App\Models\ActivityLog::where('notifiable_user_id', auth()->id())
                                            ->whereNull('read_at')
                                            ->count();
                                @endphp

                                @if ($count > 0)
                                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle"
                                        style="font-size: 0.65rem; padding: 4px 6px; border-radius: 10px;">
                                        {{ $count }}
                                    </span>
                                @endif
                            </a>

                            <div class="dropdown-menu shadow-sm" aria-labelledby="notificationDropdown"
                                style="width:360px; max-height:320px; overflow-y:auto; border-radius:8px;">
                                <div
                                    class="dropdown-header fw-bold text-primary d-flex justify-content-between align-items-center">
                                    <span>Notifications</span>
                                    <small class="text-muted">{{ now()->format('M d, Y') }}</small>
                                </div>
                                <div class="dropdown-divider"></div>

                                @forelse ($notifications ?? [] as $note)
                                    <a href="#"
                                        class="dropdown-item d-flex justify-content-between align-items-start text-dark"
                                        style="white-space: normal; font-size: 0.82rem; line-height: 1.2;">
                                        <div class="me-2">
                                            <i class="fa fa-info-circle text-primary me-2"
                                                style="font-size: 0.85rem;"></i>
                                            {{ ucfirst($note->action) }}
                                        </div>
                                        <small class="text-muted"
                                            style="font-size: 0.75rem;">{{ $note->created_at->diffForHumans() }}</small>
                                    </a>
                                @empty
                                    <div class="dropdown-item text-center text-muted py-3" style="font-size: 0.85rem;">
                                        No notifications
                                    </div>
                                @endforelse

                            </div>
                        </li>

                        {{-- force it to open LEFT even if bell is at screen edge --}}
                        <style>
                            /* make the dropdown attached to the bell's right edge, but expand LEFT */
                            #notif-wrapper .dropdown-menu {
                                left: auto !important;
                                /* ignore default left */
                                right: 0 !important;
                                /* pin to the right edge of the bell */
                                transform: translateX(0%) !important;
                                /* move whole box to the left */
                            }

                            /* optional: on very small screens, don't move it too far */
                            @media (max-width: 576px) {
                                #notif-wrapper .dropdown-menu {
                                    width: 300px;
                                    transform: translateX(-90%) !important;
                                }
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
                                <span class="name_user">{{ $u?->first_name ?? 'Guest User' }}</span>
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
    .topbar .icon_info>ul {
        overflow: visible !important;
    }

    /* make ONLY the notifications dropdown layouted */
    #notification-dropdown {
        position: static !important;
        /* <— this is the main fix */
        inset: auto !important;
        /* remove top/right auto-pos from BS */
        z-index: 1055;
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
