@include('layouts.header')
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">

    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        @include('layouts.topnav')
        <!--begin::Sidebar-->
        @include('layouts.sidenav')
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
            @yield('content')
        </main>
        <!--end::App Main-->

        @include('layouts.footer')


