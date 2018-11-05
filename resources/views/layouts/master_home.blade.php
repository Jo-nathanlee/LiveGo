<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @section('head')
        @include('PartialLayout.head_home')
    @show

    @yield('heads')

</head>

<body>
    @yield('content')
    @yield('footer')

</body>
</html>