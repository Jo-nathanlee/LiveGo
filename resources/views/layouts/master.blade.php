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
    @include('PartialLayout.sidebar_page')
    @yield('navbar')
    @include('PartialLayout.navbar_page')
    @yield('content')
    @yield('footer')

</body>
</html>