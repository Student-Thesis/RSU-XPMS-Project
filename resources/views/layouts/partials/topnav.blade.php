<div class="topbar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="full">
            <button type="button" id="sidebarCollapse" class="sidebar_toggle">
                <i class="fa fa-bars"></i>
            </button>

            {{-- <div class="logo_section">
                <a href="{{ route('dashboard') }}">
                    <img class="img-responsive" src="public/images/logo/logo.png" alt="#" />
                </a>
            </div> --}}

            <div class="right_topbar">
                <div class="icon_info">
                    <ul>
                        <li>
                            <a href="#"><i class="fa fa-question-circle"></i></a>
                        </li>
                        <li>
                            <a href="{{ route('notifications') }}"><i class="fa fa-bell-o"></i><span class="badge">2</span></a>
                        </li>

                        <li>
                            <a href="{{ route('messages') }}"><i class="fa fa-envelope-o"></i><span class="badge">3</span></a>
                        </li>
                    </ul>

                    <ul class="user_profile_dd">
                        <li class="dropdown">
                           @php
                                $u = auth()->user();
                                $avatarUrl = $u?->avatar_path
                                    ? asset('public/' . $u->avatar_path) 
                                    : asset('public/images/layout_img/default_profile.png');
                            @endphp

                            <a class="dropdown-toggle" href="#" id="userMenu" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="img-responsive rounded-circle"
                                    src="{{ $avatarUrl }}"
                                    alt="Avatar" width="40" height="40"
                                    style="object-fit: cover;" />
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
