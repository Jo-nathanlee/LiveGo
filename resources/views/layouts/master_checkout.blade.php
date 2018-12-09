<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @section('head')
        @include('PartialLayout.head')
    @show

    @yield('heads')

</head>

<body>
    @yield('wrapper')
    @yield('navbar')
    @include('PartialLayout.navbar_checkout')
    @yield('content')
    @yield('footer')

</body>
</html>