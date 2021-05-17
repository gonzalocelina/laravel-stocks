@extends('layout')
@section('content')
<div class="container text-center">
    <div class="mt-5">
        <img src="{{ asset('img/laravel-logo.svg') }}" alt="" width="150px;">
        <h2 class="mt-2">Welcome to Laravel Stocks!</h2>
        <button type="button" class="facebook-login-btn" onclick=login()>
            <img src="{{ asset('img/fb-logo.png') }}" alt="">&nbsp; Sign in
        </button>
    </div>
</div>
    <script>
        function login() {
            FB.login(function(response) {
                window.location.replace('{{ route('auth.facebook') }}');
            });
        }
    </script>
@endsection
