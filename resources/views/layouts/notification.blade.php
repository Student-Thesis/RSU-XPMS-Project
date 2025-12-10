@php
    use App\Models\Tenant\ActivityLogs;
    use Illuminate\Support\Facades\Auth;

    $tenantUser = Auth::guard('tenant')->user();

    if ($tenantUser) {
        $activityLogs = ActivityLogs::with('user')
            ->where('user_id', $tenantUser->id)
            ->latest()
            ->limit(10)
            ->get();

        $activityCount = $activityLogs->count();

        // Unique storage key per tenant user
        $storageKey = 'tenant_' . $tenantUser->id . '_notifications_seen';
    } else {
        $activityLogs = collect();
        $activityCount = 0;
        $storageKey = null;
    }
@endphp

<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#" id="notifDropdownToggle">
        <i class="bi bi-bell-fill"></i>

        @if ($activityCount > 0)
            <span class="navbar-badge badge text-bg-warning" id="notifBadge">
                {{ $activityCount }}
            </span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <span class="dropdown-item dropdown-header">
            {{ $activityCount }} Notification{{ $activityCount === 1 ? '' : 's' }}
        </span>

        @forelse($activityLogs as $log)
            <div class="dropdown-divider"></div>

            <a href="#" class="dropdown-item">
                {{-- First line: ACTIVITY NAME --}}
                <strong>{{ \Illuminate\Support\Str::limit($log->activity, 30, '...') }}</strong>

                {{-- Second line: First name (left) + Date (right) --}}
                <div class="d-flex justify-content-between align-items-center mt-1">
                    @php
                        $firstName = $log->user->first_name
                            ?? ($log->user->name ?? ($log->user_name ?? 'User'));
                    @endphp

                    <span class="text-primary">{{ $firstName }}</span>

                    <span class="text-secondary fs-7">
                        @if ($log->created_at)
                            {{ $log->created_at->diffForHumans() }}
                        @else
                            {{ \Carbon\Carbon::parse($log->date)->diffForHumans() }}
                        @endif
                    </span>
                </div>
            </a>
        @empty
            <div class="dropdown-divider"></div>
            <span class="dropdown-item text-muted">
                No notifications
            </span>
        @endforelse

        <div class="dropdown-divider"></div>
        <a href="{{ route('tenant.activity-logs.index', ['tenant' => app('currentTenant')->domain]) }}"
           class="dropdown-item dropdown-footer">
            See All Notifications
        </a>
    </div>
</li>

@if($storageKey)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const storageKey = @json($storageKey);
            const badge = document.getElementById('notifBadge');
            const toggle = document.getElementById('notifDropdownToggle');

            // If already seen before, hide badge on load
            if (localStorage.getItem(storageKey) === 'seen') {
                if (badge) {
                    badge.style.display = 'none';
                }
            }

            // When user clicks the bell dropdown, mark as seen
            if (toggle) {
                toggle.addEventListener('click', function () {
                    localStorage.setItem(storageKey, 'seen');

                    if (badge) {
                        badge.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endif
