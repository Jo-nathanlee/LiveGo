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

    @yield('content')
    @yield('footer')
    @include('PartialLayout.footer')
</body>
</html>