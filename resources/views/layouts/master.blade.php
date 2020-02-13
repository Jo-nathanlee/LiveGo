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
    @include('PartialLayout.sidebar_new')
    @yield('navbar')
    @include('PartialLayout.navbar')
    @yield('content')
    @yield('footer')
    @include('PartialLayout.footer_new')
</body>
</html>