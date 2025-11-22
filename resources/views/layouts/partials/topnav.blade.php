<div class="topbar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="full d-flex justify-content-between align-items-center w-100">

            {{-- ☰ Sidebar Toggle (doughnut) --}}
            <button type="button"
                    id="sidebarCollapse"
                    class="sidebar_toggle"
                    style="background: none; border: none;">
                <i class="fa fa-bars"></i>
            </button>

            <div class="right_topbar ms-auto">
                <div class="icon_info d-flex align-items-center">
                    <ul class="list-unstyled d-flex mb-0 me-3">

                        {{-- ✉ Messages (only for department_id = 1) --}}
                        @auth
                            @if (auth()->user()->department_id == 1)
                                @php
                                    $unreadMessages =
                                        $unreadMessageCount
                                        ?? \App\Models\Proposal::whereRaw('LOWER(status) = ?', ['pending'])->count();
                                @endphp

                                <li class="nav-item me-3">
                                    <a href="{{ route('messages') }}"
                                       class="nav-link position-relative"
                                       id="messagesLink">

                                        <i class="fa fa-envelope"></i>

                                        @if ($unreadMessages > 0)
                                            <span id="messagesBadge"
                                                  class="badge bg-danger position-absolute top-0 start-100 translate-middle"
                                                  style="font-size: 0.65rem; padding: 4px 6px; border-radius: 10px;">
                                                {{ $unreadMessages }}
                                            </span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        @endauth

                        {{-- 🔔 Notifications --}}
                        <li class="nav-item dropdown position-static" id="notif-wrapper">
                            <a href="#" class="nav-link position-relative"
                               id="notificationDropdown"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-bell-o"></i>

                                @php
                                    $count =
                                        $notificationCount ??
                                        \App\Models\ActivityLog::where('notifiable_user_id', auth()->id())
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

                            <div class="dropdown-menu shadow-sm"
                                 aria-labelledby="notificationDropdown"
                                 style="width:360px; max-height:320px; overflow-y:auto; border-radius:8px;">
                                <div class="dropdown-header fw-bold text-primary d-flex justify-content-between align-items-center">
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
                                               style="font-size: 0.75rem;">
                                            {{ $note->created_at->diffForHumans() }}
                                        </small>
                                    </a>
                                @empty
                                    <div class="dropdown-item text-center text-muted py-3"
                                         style="font-size: 0.85rem;">
                                        No notifications
                                    </div>
                                @endforelse

                            </div>
                        </li>
                    </ul>

                    {{-- 👤 User Profile --}}
                    <ul class="user_profile_dd list-unstyled mb-0" style="z-index: 999999999;">
                        <li class="dropdown">
                            @php
                                $u = auth()->user();
                                $avatarUrl = $u?->avatar_path
                                    ? asset($basePath . '/' . $u->avatar_path)
                                    : asset($basePath . '/images/layout_img/default_profile.png');
                            @endphp

                            <a class="dropdown-toggle d-flex align-items-center"
                               href="#"
                               id="userMenu"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <img class="img-responsive rounded-circle me-2"
                                     src="{{ $avatarUrl }}"
                                     alt="Avatar"
                                     width="40"
                                     height="40"
                                     style="object-fit: cover;" />
                                <span class="name_user">
                                    {{ $u?->first_name ?? 'Guest User' }}
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
                                <a class="dropdown-item" href="{{ route('settings') }}">Settings</a>
                                <a class="dropdown-item" href="{{ route('help') }}">Help</a>
                                <a class="dropdown-item"
                                   href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span>Log Out</span> <i class="fa fa-sign-out ms-1"></i>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const toggle  = document.getElementById('sidebarCollapse');

    if (!sidebar || !toggle) return;

    toggle.addEventListener('click', function () {
        // toggle mini mode
        sidebar.classList.toggle('sidebar-mini');
    });
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const badge = document.getElementById("messagesBadge");
    const link  = document.getElementById("messagesLink");
    if (!link) return;

    const storageKey = "messagesBadgeHidden";

    if (localStorage.getItem(storageKey) === "true" && badge) {
        badge.style.display = "none";
    }

    link.addEventListener("click", function () {
        if (badge) badge.style.display = "none";
        localStorage.setItem(storageKey, "true");
    });
});
</script>


<style>
    
    .hideInSmall.hidden {
        display: none !important; /* you can keep or remove this; it's no longer needed */
    }

    /* ➜ REAL logic: when sidebar is mini, hide labels */
    #sidebar.sidebar-mini .hideInSmall {
        display: none !important;
    }
    .topbar .right_topbar,
    .topbar .icon_info,
    .topbar .icon_info > ul {
        overflow: visible !important;
    }

    /* Force notification dropdown to align from the bell to the left */
    #notif-wrapper .dropdown-menu {
        left: auto !important;
        right: 0 !important;
        transform: translateX(0%) !important;
    }

    @media (max-width: 576px) {
        #notif-wrapper .dropdown-menu {
            width: 300px;
            transform: translateX(-90%) !important;
        }
    }

    #notificationDropdown .dropdown-item {
        color: #212529 !important;
        background-color: #fff !important;
    }

    #notificationDropdown .dropdown-item:hover {
        background-color: #f8f9fa !important;
        color: #000 !important;
    }.hideInSmall.hidden {
    display: none !important;
}
</style>
