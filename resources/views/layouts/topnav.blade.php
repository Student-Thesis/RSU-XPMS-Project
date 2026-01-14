@php
    use App\Models\ActivityLog;

    $user = auth()->user();

    // Global latest notifications
    $notifications = ActivityLog::latest()->take(10)->get();

    // Initial count from server (we'll refine it on the client via localStorage)
    $notifCount = $notifications->count();

    $avatarPath = $user && $user->avatar_path ? $user->avatar_path : 'adminlte/assets/img/avatar5.png';
    $avatarPath = '/' . ltrim($avatarPath, '/');
@endphp

<nav class="app-header navbar navbar-expand navbar-dark bg-dark border-bottom-0">
    <div class="container-fluid">

        <!-- Sidebar Toggle -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>

        <!-- RIGHT SECTION -->
        <ul class="navbar-nav ms-auto align-items-center">

            {{-- ✉ Messages (department_id = 1 only) --}}
            @auth
                @if ($user->department_id == 1)
                    @php
                        $unreadMessages =
                            $unreadMessageCount ??
                            \App\Models\Proposal::whereRaw('LOWER(status) = ?', ['pending'])->count();
                    @endphp

                    <li class="nav-item position-relative me-3">
                        <a href="{{ route('messages') }}" class="nav-link" id="messagesLink" aria-label="Messages">
                            <i class="bi bi-envelope"></i>
                            @if ($unreadMessages > 0)
                                <span class="navbar-badge bg-danger">{{ $unreadMessages }}</span>
                            @endif
                        </a>
                    </li>
                @endif
            @endauth

            {{-- 🔔 NOTIFICATIONS --}}
            @auth
                <li class="nav-item dropdown position-relative me-3" id="notif-wrapper">
                    <a href="#"
                       class="nav-link position-relative"
                       id="notificationDropdown"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false"
                       aria-label="Notifications">
                        <i class="bi bi-bell"></i>

                        @if ($notifCount > 0)
                            <span class="navbar-badge bg-danger" id="notifBadge">{{ $notifCount }}</span>
                        @endif
                    </a>

                    <div class="dropdown-menu shadow-sm dropdown-menu-end"
                         aria-labelledby="notificationDropdown"
                         style="width:360px; max-height:320px; overflow-y:auto; border-radius:8px;">

                        <div class="dropdown-header fw-bold text-primary d-flex justify-content-between align-items-center">
                            <span>Notifications</span>
                            <small class="text-muted">{{ now()->format('M d, Y') }}</small>
                        </div>

                        <div class="dropdown-divider"></div>

                        @forelse ($notifications as $note)
                            <a href="#"
                               class="dropdown-item d-flex justify-content-between align-items-start text-dark notif-item"
                               data-note-id="{{ $note->id }}"
                               style="white-space: normal; font-size: 0.82rem; line-height: 1.2;">
                                <div class="me-2 d-flex align-items-start">
                                    <i class="bi bi-info-circle text-primary me-2"></i>
                                    {{ ucfirst($note->action) }}
                                </div>
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    {{ $note->created_at->diffForHumans() }}
                                </small>
                            </a>
                        @empty
                            <div class="dropdown-item text-center text-muted py-3" style="font-size: 0.85rem;">
                                No notifications
                            </div>
                        @endforelse
                    </div>
                </li>
            @endauth

            {{-- USER MENU --}}
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <img src="{{ $basePath . $avatarPath }}" class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline">
                        {{ $user->first_name ?? 'Guest' }} {{ $user->last_name ?? '' }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-success">
                        <img src="{{ $basePath . $avatarPath }}" class="user-image rounded-circle shadow" alt="User Image">
                        <p>{{ $user->first_name ?? 'Guest' }} {{ $user->last_name ?? '' }}</p>
                    </li>

                    <li class="user-footer d-flex flex-column">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
                        <a class="dropdown-item" href="{{ route('settings') }}">Settings</a>
                        <a class="dropdown-item" href="{{ route('help') }}">Help</a>

                        <a class="dropdown-item text-danger"
                           href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Log Out <i class="bi bi-box-arrow-right ms-1"></i>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>

<style>
    /* Badge placed near icon */
    .navbar-badge {
        position: absolute;
        top: 0;
        right: 0;
        font-size: 0.65rem;
        padding: 3px 6px;
        border-radius: 50%;
        line-height: 1;
        z-index: 99;
    }

    .app-header .nav-link i {
        font-size: 1.25rem;
    }

    /* ✅ VERY IMPORTANT: Fix mobile content offset for AdminLTE 4 (.app-sidebar layout) */
    @media (max-width: 991.98px) {
        /* Your dashboard content is pushed right by a left padding/margin variable */
        .app-main,
        .app-content,
        .app-content-header,
        .content-wrapper,
        main,
        section {
            margin-left: 0 !important;
            padding-left: 0 !important;
        }

        /* Also make sure the header isn't offset */
        .app-header {
            margin-left: 0 !important;
        }

        /* If your body/app wrapper uses sidebar padding, kill it on mobile */
        body,
        .app-wrapper {
            padding-left: 0 !important;
        }

        /* dropdown width on small screens */
        .dropdown-menu[aria-labelledby="notificationDropdown"] {
            width: min(92vw, 360px) !important;
        }
    }

    /* ✅ Mobile: make notification dropdown full-width */
@media (max-width: 575.98px) {

    /* Target ONLY the notification dropdown */
    #notif-wrapper .dropdown-menu {
        position: fixed !important;
        left: 0 !important;
        right: 0 !important;
        top: 56px !important; /* below navbar */
        width: 100vw !important;
        max-width: 100vw !important;

        margin: 0 !important;
        border-radius: 0 !important;

        max-height: calc(100vh - 56px) !important;
        overflow-y: auto;
    }

    /* Prevent Bootstrap from forcing right alignment */
    #notif-wrapper .dropdown-menu-end {
        right: auto !important;
    }
}

</style>

@auth
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const STORAGE_KEY = 'esceo_read_notifications';
    const badge = document.getElementById('notifBadge');
    const dropdown = document.getElementById('notificationDropdown');
    const notifItems = document.querySelectorAll('.notif-item');

    if (!notifItems.length) return;

    function loadReadIds() {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            const parsed = raw ? JSON.parse(raw) : [];
            return Array.isArray(parsed) ? parsed : [];
        } catch (e) {
            return [];
        }
    }

    function saveReadIds(ids) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));
    }

    function getCurrentIds() {
        return Array.from(notifItems)
            .map(el => el.getAttribute('data-note-id'))
            .filter(Boolean);
    }

    function refreshBadge() {
        if (!badge) return;

        const readIds = loadReadIds();
        const currentIds = getCurrentIds();
        const unreadIds = currentIds.filter(id => !readIds.includes(id));

        if (unreadIds.length === 0) {
            badge.style.display = 'none';
        } else {
            badge.style.display = 'inline-block';
            badge.textContent = unreadIds.length;
        }
    }

    if (dropdown) {
        dropdown.addEventListener('shown.bs.dropdown', function () {
            const readIds = loadReadIds();
            const currentIds = getCurrentIds();
            const merged = Array.from(new Set([...readIds, ...currentIds]));
            saveReadIds(merged);

            if (badge) badge.style.display = 'none';
        });
    }

    refreshBadge();
});
</script>
@endpush
@endauth
