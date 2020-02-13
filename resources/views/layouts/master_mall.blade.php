<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @section('head')
        @include('PartialLayout.head')
        <link rel="icon" href="https://livego.com.tw/img/livego.png" type="image/x-icon" />
    @show

    @yield('heads')

</head>

<body>
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v4.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/zh_TW/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your customer chat code -->
      <div class="fb-customerchat"
        attribution=setup_tool
        page_id="{{ app('request')->input('page_id') }}"
        theme_color="#4f4f4f"
        logged_in_greeting="您好！歡迎光臨！有什麼可以幫助您的嗎？"
        logged_out_greeting="您好！歡迎光臨！有什麼可以幫助您的嗎？">
      </div>
    @yield('wrapper')
    @yield('navbar')
    @include('PartialLayout.navbar_mall')
    @yield('content')
    @yield('footer')
    @include('PartialLayout.footer')
</body>
</html>