<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.ico') }}">
    <title>Laravel</title>

    <link href = {{ asset("css/app.css") }} rel="stylesheet" />
    <link href = {{ asset("css/styles.css") }} rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<!-- Facebook JS API -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId            : '{{ env('FB_APP_ID')}}',
            autoLogAppEvents : true,
            cookie           : true,
            xfbml            : true,
            version          : 'v10.0'
        });

        FB.getLoginStatus(function(response) {});
    };
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<!-- /Facebook JS API -->
@yield('content')
</body>
</html>

