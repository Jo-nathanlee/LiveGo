<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @section('head')
        @include('PartialLayout.head_mall')
    @show

    @yield('heads')

</head>

<body>
    @yield('wrapper')
    @include('PartialLayout.sidebar_mall')
    @yield('navbar')
    @include('PartialLayout.navbar_mall')
    @yield('content')
    @yield('footer')

</body>
</html>