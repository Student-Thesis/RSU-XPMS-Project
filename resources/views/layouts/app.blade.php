@include('layouts.partials.header')
@include('layouts.partials.sidenav')
@yield('content')
@if(session('permission_error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Access Denied',
            text: '{{ session('permission_error') }}',
            confirmButtonColor: '#d33'
        });
    </script>
@endif

 @stack('scripts') 
@include('layouts.partials.footer')


