<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @section('head')
        @include('PartialLayout.head_new')
    @show

    @yield('head_extension')

</head>

<body>
    @yield('wrapper')
    @include('PartialLayout.sidebarshop_new')
    @yield('navbar')
    @include('PartialLayout.navbar_shop')
    @yield('content')
    @yield('footer')
    @include('PartialLayout.footer_new')
</body>
</html>