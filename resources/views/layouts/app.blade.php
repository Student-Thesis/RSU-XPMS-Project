@include('layouts.partials.header')
@include('layouts.partials.sidenav')
@yield('content')
 @stack('scripts') 
@include('layouts.partials.footer')


